<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tugas;
use App\Models\Penugasan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

    public function rekapPenugasan(Request $request)
    {
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);

        $pegawai = User::where('role', 'pegawai')
            ->with(['penugasan' => function($query) use ($bulan, $tahun) {
                $query->whereMonth('assigned_at', $bulan)
                      ->whereYear('assigned_at', $tahun)
                      ->with('tugas');
            }])
            ->get();

        // Hitung statistik per pegawai
        $pegawai = $pegawai->map(function($p) {
            $p->total_tugas = $p->penugasan->count();
            $p->total_jam = $p->penugasan->sum(function($penugasan) {
                return $penugasan->tugas->durasi ?? 0;
            });
            return $p;
        });

        return view('admin.laporan.rekap-penugasan', compact('pegawai', 'bulan', 'tahun'));
    }

    public function statistikBebanKerja(Request $request)
    {
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);

        $pegawai = User::where('role', 'pegawai')
            ->withCount(['penugasan as total_tugas' => function($query) use ($bulan, $tahun) {
                $query->whereMonth('assigned_at', $bulan)
                      ->whereYear('assigned_at', $tahun);
            }])
            ->with(['penugasan' => function($query) use ($bulan, $tahun) {
                $query->whereMonth('assigned_at', $bulan)
                      ->whereYear('assigned_at', $tahun)
                      ->with('tugas');
            }])
            ->get();

        // Hitung total jam kerja per pegawai
        $pegawai = $pegawai->map(function($p) {
            $p->total_jam = $p->penugasan->sum(function($penugasan) {
                return $penugasan->tugas->durasi ?? 0;
            });
            return $p;
        });

        // Statistik
        $totalTugas = $pegawai->sum('total_tugas');
        $rataRataTugas = $pegawai->count() > 0 ? round($totalTugas / $pegawai->count(), 2) : 0;
        $pegawaiTertinggi = $pegawai->sortByDesc('total_tugas')->first();
        $pegawaiTerendah = $pegawai->sortBy('total_tugas')->first();

        return view('admin.laporan.statistik-beban', compact(
            'pegawai', 
            'bulan', 
            'tahun', 
            'totalTugas', 
            'rataRataTugas', 
            'pegawaiTertinggi', 
            'pegawaiTerendah'
        ));
    }

    public function exportPDF(Request $request)
    {
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);

        $pegawai = User::where('role', 'pegawai')
            ->withCount(['penugasan as total_tugas' => function($query) use ($bulan, $tahun) {
                $query->whereMonth('assigned_at', $bulan)
                      ->whereYear('assigned_at', $tahun);
            }])
            ->with(['penugasan' => function($query) use ($bulan, $tahun) {
                $query->whereMonth('assigned_at', $bulan)
                      ->whereYear('assigned_at', $tahun)
                      ->with('tugas');
            }])
            ->get();

        $pegawai = $pegawai->map(function($p) {
            $p->total_jam = $p->penugasan->sum(function($penugasan) {
                return $penugasan->tugas->durasi ?? 0;
            });
            return $p;
        });

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('pegawai', 'bulan', 'tahun'));
        return $pdf->download('laporan-penugasan-' . $bulan . '-' . $tahun . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);

        $pegawai = User::where('role', 'pegawai')
            ->with(['penugasan' => function($query) use ($bulan, $tahun) {
                $query->whereMonth('assigned_at', $bulan)
                      ->whereYear('assigned_at', $tahun)
                      ->with('tugas');
            }])
            ->get();

        $csvData = "NIP,Nama,Jabatan,Seksi,Nama Tugas,Tanggal,Lokasi,Durasi (jam),Prioritas,Status\n";

        foreach ($pegawai as $p) {
            if ($p->penugasan->count() == 0) {
                // Pegawai tanpa tugas
                $csvData .= sprintf(
                    "%s,%s,%s,%s,-,-,-,-,-,-\n",
                    $p->nip,
                    $p->name,
                    $p->jabatan,
                    $p->seksi
                );
            } else {
                foreach ($p->penugasan as $penugasan) {
                    $tugas = $penugasan->tugas;
                    $csvData .= sprintf(
                        "%s,%s,%s,%s,%s,%s,%s,%s,%s,%s\n",
                        $p->nip,
                        $p->name,
                        $p->jabatan,
                        $p->seksi,
                        $tugas->nama_tugas,
                        $tugas->tanggal->format('Y-m-d'),
                        $tugas->lokasi,
                        $tugas->durasi,
                        $tugas->prioritas,
                        $tugas->status
                    );
                }
            }
        }

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="laporan-penugasan-' . $bulan . '-' . $tahun . '.csv"',
        ]);
    }

    public function detailPegawai(Request $request, User $pegawai)
    {
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);

        $penugasan = $pegawai->penugasan()
            ->whereMonth('assigned_at', $bulan)
            ->whereYear('assigned_at', $tahun)
            ->with('tugas')
            ->orderBy('assigned_at', 'desc')
            ->get();

        $statistik = [
            'total_tugas' => $penugasan->count(),
            'total_jam' => $penugasan->sum(function($p) {
                return $p->tugas->durasi ?? 0;
            }),
            'tugas_selesai' => $penugasan->where('tugas.status', 'selesai')->count(),
            'tugas_aktif' => $penugasan->whereIn('tugas.status', ['assigned', 'pending'])->count(),
        ];

        return view('admin.laporan.detail-pegawai', compact('pegawai', 'penugasan', 'statistik', 'bulan', 'tahun'));
    }
}
