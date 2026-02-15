<?php
// ============================================
// app/Http/Controllers/Admin/SchedulingController.php
// ============================================
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tugas;
use App\Models\Penugasan;
use App\Models\RoundRobinQueue;
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
            Penugasan::create([
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

            $assigned++;
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
            return back()->with('error', 'Pegawai sudah mencapai batas maksimal tugas');
        }

        // Assign
        Penugasan::create([
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

        return back()->with('success', 'Tugas berhasil ditugaskan ke ' . $user->name);
    }

    /**
     * Reset Queue
     */
    public function resetQueue()
    {
        RoundRobinQueue::initialize();

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

        return back()->with('success', 'Pengaturan beban kerja berhasil diperbarui');
    }

    /**
     * Unassign Task
     */
    public function unassign(Tugas $tugas)
    {
        $penugasan = $tugas->penugasan()->first();

        if ($penugasan) {
            $penugasan->delete();
            $tugas->update(['status' => 'pending']);

            return back()->with('success', 'Penugasan berhasil dibatalkan');
        }

        return back()->with('error', 'Tugas belum ditugaskan');
    }
}
