<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tugas;
use App\Models\Penugasan;
use App\Models\RoundRobinQueue;
use App\Providers\NotificationService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PenjadwalanController extends Controller
{
    /**
     * Halaman Scheduling
     */
    public function index(Request $request)
    {
        // Filter
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);
        $seksi = $request->input('seksi');

        // Get pegawai dengan beban kerja
        $pegawaiQuery = User::where('role', 'pegawai')
            ->withCount(['penugasan as tugas_bulan_ini' => function ($query) use ($bulan, $tahun) {
                $query->whereMonth('assigned_at', $bulan)
                    ->whereYear('assigned_at', $tahun);
            }]);

        if ($seksi) {
            $pegawaiQuery->where('seksi', $seksi);
        }

        $pegawai = $pegawaiQuery->get()->map(function ($p) use ($bulan, $tahun) {
            $p->jam_bulan_ini = $p->penugasan()
                ->whereMonth('assigned_at', $bulan)
                ->whereYear('assigned_at', $tahun)
                ->with('tugas')
                ->get()
                ->sum(function ($penugasan) {
                    return $penugasan->tugas->durasi ?? 0;
                });

            $p->persentase_beban = $p->max_tugas_bulanan > 0
                ? round(($p->tugas_bulan_ini / $p->max_tugas_bulanan) * 100, 1)
                : 0;

            return $p;
        });

        // Get tugas pending
        $tugasPending = Tugas::where('status', 'pending')
            ->orderBy('prioritas', 'desc')
            ->orderBy('tanggal', 'asc')
            ->get();

        // Queue statistics
        $queueStats = RoundRobinQueue::with('user')->orderBy('position')->get();

        // Statistik
        $stats = [
            'total_pegawai' => User::where('role', 'pegawai')->count(),
            'pegawai_available' => $pegawai->filter(fn($p) => $p->canReceiveTask())->count(),
            'tugas_pending' => $tugasPending->count(),
            'avg_beban' => $pegawai->avg('persentase_beban') ?? 0,
        ];

        // List seksi
        $seksiList = User::where('role', 'pegawai')
            ->distinct()
            ->pluck('seksi');

        return view('admin.penjadwalan.index', compact(
            'pegawai',
            'tugasPending',
            'queueStats',
            'stats',
            'seksiList',
            'bulan',
            'tahun',
            'seksi'
        ));
    }

    /**
     * Run Automated Scheduler
     */
    public function runScheduler(Request $request)
    {
        $validated = $request->validate([
            'tugas_ids' => 'required|array',
            'tugas_ids.*' => 'exists:tugas,id'
        ]);

        $assigned = 0;
        $failed = [];
        $assignedUsers = []; // Track users yang mendapat tugas

        foreach ($validated['tugas_ids'] as $tugasId) {
            $tugas = Tugas::find($tugasId);

            if ($tugas->status !== 'pending') {
                continue;
            }

            $queue = RoundRobinQueue::getNextAvailable();

            if (!$queue) {
                $failed[] = $tugas->nama_tugas;
                continue;
            }

            // Assign tugas
            $penugasan = Penugasan::create([
                'tugas_id' => $tugas->id,
                'user_id' => $queue->user_id,
                'assigned_at' => Carbon::now(),
            ]);

            $tugas->update(['status' => 'assigned']);

            // Update queue
            $queue->total_assigned += 1;
            $queue->last_assigned_at = Carbon::now();
            $queue->save();
            $queue->rotate();

            // Track untuk notifikasi
            if (!isset($assignedUsers[$queue->user_id])) {
                $assignedUsers[$queue->user_id] = 0;
            }
            $assignedUsers[$queue->user_id]++;

            // Kirim notifikasi ke pegawai
            $user = User::find($queue->user_id);
            if ($user) {
                NotificationService::taskAssigned($user, $tugas, $penugasan);
                
                // Notifikasi khusus untuk tugas prioritas tinggi
                if ($tugas->prioritas === 'tinggi' || $tugas->prioritas === 'urgent') {
                    NotificationService::highPriorityTask($user, $tugas);
                }
            }

            $assigned++;
        }

        // Kirim notifikasi ringkasan ke setiap pegawai yang mendapat tugas
        foreach ($assignedUsers as $userId => $count) {
            $user = User::find($userId);
            if ($user) {
                NotificationService::autoSchedulingCompleted($user, $count);
            }
        }

        // Kirim notifikasi ke admin
        if ($assigned > 0) {
            NotificationService::allTasksScheduled($assigned);
        }

        if (count($failed) > 0) {
            NotificationService::noPegawaiAvailable(count($failed));
        }

        $message = "$assigned tugas berhasil dijadwalkan.";
        if (count($failed) > 0) {
            $message .= " " . count($failed) . " tugas gagal (tidak ada pegawai tersedia).";
        }

        return redirect()->route('admin.penjadwalan.index')
            ->with('success', $message);
    }

    /**
     * Manual Assignment
     */
    public function assignManual(Request $request)
    {
        $validated = $request->validate([
            'tugas_id' => 'required|exists:tugas,id',
            'user_id' => 'required|exists:users,id'
        ]);

        $tugas = Tugas::find($validated['tugas_id']);
        $user = User::find($validated['user_id']);

        if (!$user->canReceiveTask()) {
            // Kirim notifikasi ke admin
            NotificationService::notifyAdmin(
                title: 'Penugasan Manual Gagal',
                message: "Gagal menugaskan '{$tugas->nama_tugas}' ke {$user->name} karena sudah mencapai batas maksimal",
                type: 'warning',
                url: route('admin.penjadwalan.index')
            );

            return back()->with('error', 'Pegawai sudah mencapai batas maksimal tugas');
        }

        // Assign
        $penugasan = Penugasan::create([
            'tugas_id' => $tugas->id,
            'user_id' => $user->id,
            'assigned_at' => Carbon::now(),
        ]);

        $tugas->update(['status' => 'assigned']);

        // Update queue stats
        $queue = RoundRobinQueue::where('user_id', $user->id)->first();
        if ($queue) {
            $queue->total_assigned += 1;
            $queue->last_assigned_at = Carbon::now();
            $queue->save();
        }

        // Kirim notifikasi ke pegawai
        NotificationService::taskAssigned($user, $tugas, $penugasan);

        // Notifikasi khusus untuk tugas prioritas tinggi
        if ($tugas->prioritas === 'tinggi' || $tugas->prioritas === 'urgent') {
            NotificationService::highPriorityTask($user, $tugas);
        }

        // Cek apakah pegawai mendekati batas
        if (!$user->canReceiveTask()) {
            NotificationService::workloadLimitReached($user);
        }

        return back()->with('success', 'Tugas berhasil ditugaskan ke ' . $user->name);
    }

    /**
     * Reset Queue
     */
    public function resetQueue()
    {
        RoundRobinQueue::initialize();

        // Kirim notifikasi ke admin
        NotificationService::queueReset();

        // Notifikasi ke semua pegawai
        $pegawai = User::where('role', 'pegawai')->get();
        foreach ($pegawai as $p) {
            $queue = RoundRobinQueue::where('user_id', $p->id)->first();
            if ($queue) {
                NotificationService::queueRotated($p, $queue->position);
            }
        }

        return back()->with('success', 'Queue Round Robin berhasil direset');
    }

    /**
     * Update Settings
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'max_tugas_mingguan' => 'required|integer|min:1',
            'max_tugas_bulanan' => 'required|integer|min:1'
        ]);

        $user = User::find($validated['user_id']);
        $user->update([
            'max_tugas_mingguan' => $validated['max_tugas_mingguan'],
            'max_tugas_bulanan' => $validated['max_tugas_bulanan']
        ]);

        // Kirim notifikasi ke pegawai
        NotificationService::workloadSettingsUpdated(
            $user,
            $validated['max_tugas_mingguan'],
            $validated['max_tugas_bulanan']
        );

        // Notifikasi ke admin yang melakukan update
        NotificationService::notifyAdmin(
            title: 'Pengaturan Beban Kerja Diperbarui',
            message: "Beban kerja {$user->name} telah diperbarui",
            type: 'success',
            url: route('admin.penjadwalan.index')
        );

        return back()->with('success', 'Pengaturan beban kerja berhasil diperbarui');
    }

    /**
     * Unassign Task
     */
    public function unassign(Tugas $tugas)
    {
        $penugasan = $tugas->penugasan()->first();

        if ($penugasan) {
            $user = $penugasan->user;
            
            $penugasan->delete();
            $tugas->update(['status' => 'pending']);

            // Kirim notifikasi ke pegawai
            if ($user) {
                NotificationService::taskUnassigned($user, $tugas);
            }

            // Notifikasi ke admin
            NotificationService::notifyAdmin(
                title: 'Penugasan Dibatalkan',
                message: "Penugasan '{$tugas->nama_tugas}' untuk {$user->name} telah dibatalkan",
                type: 'warning',
                url: route('admin.penjadwalan.index')
            );

            return back()->with('success', 'Penugasan berhasil dibatalkan');
        }

        return back()->with('error', 'Tugas belum ditugaskan');
    }

    /**
     * Bulk assign by seksi
     */
    public function assignBySeksi(Request $request)
    {
        $validated = $request->validate([
            'seksi' => 'required|string',
            'tugas_ids' => 'required|array',
            'tugas_ids.*' => 'exists:tugas,id'
        ]);

        $pegawai = User::where('role', 'pegawai')
            ->where('seksi', $validated['seksi'])
            ->where(function($q) {
                $q->whereRaw('
                    (SELECT COUNT(*) FROM penugasan 
                     WHERE penugasan.user_id = users.id 
                     AND MONTH(penugasan.assigned_at) = MONTH(CURRENT_DATE)
                     AND YEAR(penugasan.assigned_at) = YEAR(CURRENT_DATE)) 
                    < users.max_tugas_bulanan
                ');
            })
            ->get();

        if ($pegawai->isEmpty()) {
            return back()->with('error', 'Tidak ada pegawai tersedia di seksi ini');
        }

        $assigned = 0;
        $pegawaiIndex = 0;

        foreach ($validated['tugas_ids'] as $tugasId) {
            $tugas = Tugas::find($tugasId);
            
            if ($tugas->status !== 'pending') {
                continue;
            }

            $user = $pegawai[$pegawaiIndex % $pegawai->count()];

            $penugasan = Penugasan::create([
                'tugas_id' => $tugas->id,
                'user_id' => $user->id,
                'assigned_at' => Carbon::now(),
            ]);

            $tugas->update(['status' => 'assigned']);

            // Kirim notifikasi
            NotificationService::taskAssigned($user, $tugas, $penugasan);

            $assigned++;
            $pegawaiIndex++;
        }

        // Notifikasi ke admin dan seksi
        NotificationService::notifyAdmin(
            title: 'Penugasan Massal Selesai',
            message: "{$assigned} tugas berhasil ditugaskan ke seksi {$validated['seksi']}",
            type: 'success',
            url: route('admin.penjadwalan.index')
        );

        NotificationService::notifyBySeksi(
            seksi: $validated['seksi'],
            title: 'Penugasan Massal',
            message: "Seksi {$validated['seksi']} telah menerima {$assigned} tugas baru",
            type: 'info',
            url: route('pegawai.jadwal')
        );

        return back()->with('success', "{$assigned} tugas berhasil ditugaskan ke seksi {$validated['seksi']}");
    }
}