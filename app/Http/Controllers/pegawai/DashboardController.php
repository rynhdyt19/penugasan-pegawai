<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Tugas;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $tugasAktif = $user->penugasan()
            ->whereHas('tugas', function ($q) {
                $q->where('status', 'assigned');
            })
            ->count();

        $tugasSelesai = $user->penugasan()
            ->whereHas('tugas', function ($q) {
                $q->where('status', 'selesai');
            })
            ->count();

        $tugasMingguIni = $user->tugasMingguan();
        $tugasBulanIni = $user->tugasBulanan();

        $jadwalTugas = $user->penugasan()
            ->with('tugas')
            ->whereHas('tugas', function ($q) {
                $q->whereIn('status', ['assigned', 'pending'])
                    ->where('tanggal', '>=', Carbon::now());
            })
            ->orderBy('assigned_at', 'desc')
            ->take(10)
            ->get();

        // 🔹 Tambahkan bagian ini:
        $tugasMendatang = $user->penugasan()
            ->with('tugas')
            ->whereHas('tugas', function ($q) {
                $q->whereBetween('tanggal', [Carbon::now(), Carbon::now()->addDays(7)]);
            })
            ->get()
            ->sortBy(fn($penugasan) => $penugasan->tugas->tanggal ?? now());


        // Informasi beban kerja
        // 🔹 Beban kerja
        $bebanKerja = [
            'mingguan' => [
                'current' => $tugasMingguIni,
                'max' => $user->max_tugas_mingguan,
                'percentage' => $user->max_tugas_mingguan > 0 ? round(($tugasMingguIni / $user->max_tugas_mingguan) * 100, 2) : 0,
                'sisa' => max($user->max_tugas_mingguan - $tugasMingguIni, 0),
            ],
            'bulanan' => [
                'current' => $tugasBulanIni,
                'max' => $user->max_tugas_bulanan,
                'percentage' => $user->max_tugas_bulanan > 0 ? round(($tugasBulanIni / $user->max_tugas_bulanan) * 100, 2) : 0,
                'sisa' => max($user->max_tugas_bulanan - $tugasBulanIni, 0),
            ],
        ];

        // 🔹 Pastikan semua variabel dikirim ke view
        return view('pegawai.dashboard', compact(
            'tugasAktif',
            'tugasSelesai',
            'tugasMingguIni',
            'tugasBulanIni',
            'tugasMendatang',
            'bebanKerja'
        ));
    }

    public function riwayatTugas(Request $request)
    {
        $user = Auth::user();

        // =========================
        // FILTER INPUT
        // =========================
        $status = $request->query('status');
        $bulan  = $request->query('bulan');
        $tahun  = $request->query('tahun');

        // =========================
        // QUERY RIWAYAT TUGAS
        // =========================
        $query = $user->penugasan()
            ->with('tugas')
            ->orderBy('assigned_at', 'desc');

        // Filter status
        if ($status) {
            $query->whereHas('tugas', function ($q) use ($status) {
                $q->where('status', $status);
            });
        }

        // Filter bulan
        if ($bulan) {
            $query->whereHas('tugas', function ($q) use ($bulan) {
                $q->whereMonth('tanggal', $bulan);
            });
        }

        // Filter tahun
        if ($tahun) {
            $query->whereHas('tugas', function ($q) use ($tahun) {
                $q->whereYear('tanggal', $tahun);
            });
        }

        // =========================
        // DATA RIWAYAT (PAGINATION)
        // =========================
        $riwayat = $query->paginate(10)->withQueryString();

        // =========================
        // STATISTIK
        // =========================
        $totalTugas = $user->penugasan()->count();

        $totalJam = $user->penugasan()
            ->join('tugas', 'penugasan.tugas_id', '=', 'tugas.id')
            ->sum('tugas.durasi');

        // =========================
        // RETURN VIEW
        // =========================
        return view('pegawai.riwayat-tugas', compact(
            'riwayat',
            'totalTugas',
            'totalJam',
            'status',
            'bulan',
            'tahun'
        ));
    }

    public function jadwalTugas(Request $request)
    {
        $user = Auth::user();

        $bulan = $request->query('bulan', now()->month);
        $tahunSaatIni = $request->query('tahun', now()->year);

        $jadwal = $user->penugasan()
            ->with('tugas')
            ->whereHas('tugas', function ($q) use ($bulan, $tahunSaatIni) {
                $q->whereNotIn('status', ['selesai'])
                    ->whereYear('tanggal', $tahunSaatIni)
                    ->whereMonth('tanggal', $bulan);
            })
            ->orderBy('assigned_at', 'asc')
            ->get();

        // ✅ INI YANG KURANG
        $jadwalByDate = $jadwal->groupBy(function ($item) {
            return Carbon::parse($item->tugas->tanggal)->format('Y-m-d');
        });

        return view('pegawai.jadwal-tugas', [
            'jadwalByDate' => $jadwalByDate,
            'bulan'        => $bulan,
            'tahunSaatIni' => $tahunSaatIni,
        ]);
    }

    public function detailTugas(Tugas $tugas)
    {
        $user = Auth::user();

        // Pastikan tugas memang milik pegawai ini
        $penugasan = $user->penugasan()
            ->where('tugas_id', $tugas->id)
            ->with('tugas')
            ->firstOrFail();

        return view('pegawai.detail-tugas', compact('penugasan', 'tugas'));
    }

    public function profil()
    {
        $user = Auth::user();

        $statistik = [
            'tugas_aktif' => $user->penugasan()
                ->whereHas('tugas', fn($q) => $q->where('status', 'assigned'))
                ->count(),

            'tugas_selesai' => $user->penugasan()
                ->whereHas('tugas', fn($q) => $q->where('status', 'selesai'))
                ->count(),

            'total_tugas' => $user->penugasan()->count(),

            'total_jam' => $user->penugasan()
                ->whereHas('tugas', fn($q) => $q->where('status', 'selesai'))
                ->with('tugas')
                ->get()
                ->sum(fn($p) => $p->tugas->durasi ?? 0),

            // ✅ FIX ERROR BARU DI SINI
            'tugas_bulan_ini' => $user->penugasan()
                ->whereHas('tugas', function ($q) {
                    $q->whereMonth('tanggal', now()->month)
                        ->whereYear('tanggal', now()->year);
                })
                ->count(),
        ];

        return view('pegawai.profil', compact('user', 'statistik'));
    }
}
