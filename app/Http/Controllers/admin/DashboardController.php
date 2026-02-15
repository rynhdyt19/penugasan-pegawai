<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tugas;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // =====================
        // STATISTIK UTAMA
        // =====================
        $totalPegawai = User::where('role', 'pegawai')->count();
        $totalTugas   = Tugas::count();
        $tugasPending = Tugas::where('status', 'pending')->count();
        $tugasSelesai = Tugas::where('status', 'selesai')->count();

        // =====================
        // TUGAS MINGGU INI
        // =====================
        $tugasMingguIni = Tugas::whereBetween('tanggal', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();

        // =====================
        // TOP PEGAWAI BULAN INI
        // =====================
        $topPegawai = User::where('role', 'pegawai')
            ->withCount(['penugasan' => function ($query) {
                $query->whereBetween('assigned_at', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ]);
            }])
            ->orderBy('penugasan_count', 'desc')
            ->take(5)
            ->get();

        // =====================
        // LIST PEGAWAI
        // =====================
        $pegawaiList = User::where('role', 'pegawai')
            ->orderBy('name')
            ->get();

        // =====================
        // DISTRIBUSI SEKSI
        // =====================
        $sections = User::where('role', 'pegawai')
            ->select('seksi', DB::raw('count(*) as total'))
            ->groupBy('seksi')
            ->get();

        $maxCount = $sections->max('total') ?? 1;

        // =====================
        // TUGAS TERBARU
        // =====================
        $tugasTerbaru = Tugas::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // =====================
        // KIRIM KE VIEW (SATU-SATUNYA RETURN)
        // =====================
        return view('admin.dashboard', [
            'totalPegawai'    => $totalPegawai,
            'totalTugas'      => $totalTugas,
            'tugasPending'    => $tugasPending,
            'tugasSelesai'    => $tugasSelesai,
            'tugasMingguIni'  => $tugasMingguIni,
            'topPegawai'      => $topPegawai,
            'pegawaiList'     => $pegawaiList,
            'sections'        => $sections,
            'maxCount'        => $maxCount,
            'tugasTerbaru'    => $tugasTerbaru,
        ]);
    }
}
