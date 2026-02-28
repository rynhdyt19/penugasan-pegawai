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
     * Halaman Scheduling - Menampilkan daftar pegawai dan beban kerja
     */
    public function index(Request $request)
    {
        // Ambil filter dari request
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);
        $seksi = $request->input('seksi');

        // Query pegawai dengan hitungan penugasan berdasarkan filter waktu
        $pegawaiQuery = User::where('role', 'pegawai')
            ->withCount(['penugasan as tugas_bulan_ini' => function ($query) use ($bulan, $tahun) {
                $query->whereMonth('assigned_at', $bulan)
                    ->whereYear('assigned_at', $tahun);
            }]);

        if ($seksi) {
            $pegawaiQuery->where('seksi', $seksi);
        }

        $pegawai = $pegawaiQuery->get()->map(function ($p) use ($bulan, $tahun) {
            // Hitung total durasi jam kerja bulan ini
            $p->jam_bulan_ini = $p->penugasan()
                ->whereMonth('assigned_at', $bulan)
                ->whereYear('assigned_at', $tahun)
                ->with('tugas')
                ->get()
                ->sum(function ($penugasan) {
                    return $penugasan->tugas->durasi ?? 0;
                });

            // Hitung persentase beban kerja terhadap batas maksimal
            $p->persentase_beban = $p->max_tugas_bulanan > 0
                ? round(($p->tugas_bulan_ini / $p->max_tugas_bulanan) * 100, 1)
                : 0;

            return $p;
        });

        $tugasPending = Tugas::where('status', 'pending')
            ->orderBy('prioritas', 'desc')
            ->orderBy('tanggal', 'asc')
            ->get();

        $queueStats = RoundRobinQueue::with('user')->orderBy('position')->get();

        $stats = [
            'total_pegawai' => User::where('role', 'pegawai')->count(),
            'pegawai_available' => $pegawai->filter(fn($p) => $p->canReceiveTask())->count(),
            'tugas_pending' => $tugasPending->count(),
            'avg_beban' => $pegawai->avg('persentase_beban') ?? 0,
        ];

        $seksiList = User::where('role', 'pegawai')->distinct()->pluck('seksi');

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
     * Run Automated Scheduler dengan Peringatan Beban Kerja
     */
    public function runScheduler(Request $request)
    {
        $validated = $request->validate([
            'tugas_ids' => 'required|array',
            'tugas_ids.*' => 'exists:tugas,id'
        ]);

        $assigned = 0;
        $failed = [];
        $overloadedUsers = []; // Untuk menampung nama pegawai yang mencapai limit

        foreach ($validated['tugas_ids'] as $tugasId) {
            $tugas = Tugas::find($tugasId);

            if ($tugas->status !== 'pending') continue;

            $queue = RoundRobinQueue::getNextAvailable();

            if (!$queue) {
                $failed[] = $tugas->nama_tugas;
                continue;
            }

            $user = User::find($queue->user_id);

            // 1. CEK SEBELUM ASSIGN: Jika user sudah penuh, cari user lain (rotate queue)
            if (!$user->canReceiveTask()) {
                $overloadedUsers[] = $user->name;
                $queue->rotate(); // Geser antrean karena user ini penuh

                // Coba ambil user berikutnya setelah rotasi
                $queue = RoundRobinQueue::getNextAvailable();
                if (!$queue) {
                    $failed[] = $tugas->nama_tugas;
                    continue;
                }
                $user = User::find($queue->user_id);
            }

            // 2. PROSES PENUGASAN
            $penugasan = Penugasan::create([
                'tugas_id' => $tugas->id,
                'user_id' => $user->id,
                'assigned_at' => Carbon::now(),
            ]);

            $tugas->update(['status' => 'assigned']);

            // Update statistik antrean
            $queue->total_assigned += 1;
            $queue->last_assigned_at = Carbon::now();
            $queue->save();
            $queue->rotate();

            // 3. CEK SETELAH ASSIGN: Apakah sekarang menjadi penuh?
            if (!$user->fresh()->canReceiveTask()) {
                $overloadedUsers[] = $user->name;
                NotificationService::workloadLimitReached($user);
            }

            // Kirim notifikasi tugas baru
            NotificationService::taskAssigned($user, $tugas, $penugasan);
            $assigned++;
        }

        // Susun Pesan Alert
        $message = "$assigned tugas berhasil dijadwalkan.";
        $type = 'success';

        if (count($failed) > 0) {
            $message .= " " . count($failed) . " tugas gagal (tidak ada pegawai tersedia).";
            $type = 'warning';
        }

        if (count($overloadedUsers) > 0) {
            $uniqueOverloaded = array_unique($overloadedUsers);
            $names = implode(', ', $uniqueOverloaded);
            $message .= " Peringatan: Pegawai berikut telah mencapai batas maksimal tugas: ($names).";
            $type = 'warning';
        }

        return redirect()->route('admin.penjadwalan.index')->with($type, $message);
    }

    /**
     * Manual Assignment dengan Validasi Ketat & Alert
     */
    public function assignManual(Request $request)
    {
        $validated = $request->validate([
            'tugas_id' => 'required|exists:tugas,id',
            'user_id' => 'required|exists:users,id'
        ]);

        $tugas = Tugas::find($validated['tugas_id']);
        $user = User::find($validated['user_id']);

        // Proteksi jika dipaksa lewat manual padahal sudah penuh
        if (!$user->canReceiveTask()) {
            return back()->with('error', "Gagal! {$user->name} sudah mencapai batas maksimal tugas mingguan/bulanan.");
        }

        $penugasan = Penugasan::create([
            'tugas_id' => $tugas->id,
            'user_id' => $user->id,
            'assigned_at' => Carbon::now(),
        ]);

        $tugas->update(['status' => 'assigned']);

        // Sinkronisasi dengan Queue
        $queue = RoundRobinQueue::where('user_id', $user->id)->first();
        if ($queue) {
            $queue->total_assigned += 1;
            $queue->last_assigned_at = Carbon::now();
            $queue->save();
        }

        NotificationService::taskAssigned($user, $tugas, $penugasan);

        $statusMessage = "Tugas berhasil ditugaskan ke {$user->name}.";

        // Alert tambahan jika setelah ditugaskan beban langsung penuh
        if (!$user->fresh()->canReceiveTask()) {
            NotificationService::workloadLimitReached($user);
            $statusMessage .= " Catatan: Pegawai telah mencapai batas maksimal beban kerja setelah tugas ini.";
            return back()->with('warning', $statusMessage);
        }

        return back()->with('success', $statusMessage);
    }

    /**
     * Update Settings Beban Kerja
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

        NotificationService::workloadSettingsUpdated($user, $validated['max_tugas_mingguan'], $validated['max_tugas_bulanan']);

        return back()->with('success', "Batas beban kerja {$user->name} berhasil diperbarui.");
    }

    public function unassign(Tugas $tugas)
    {
        $penugasan = $tugas->penugasan()->first();
        if ($penugasan) {
            $user = $penugasan->user;
            $penugasan->delete();
            $tugas->update(['status' => 'pending']);

            if ($user) NotificationService::taskUnassigned($user, $tugas);

            return back()->with('success', 'Penugasan dibatalkan. Pegawai kini memiliki slot tugas kembali.');
        }
        return back()->with('error', 'Tugas memang belum ditugaskan.');
    }
}
