<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use App\Models\Penugasan;
use App\Models\RoundRobinQueue;
use App\Models\User;
use Illuminate\Http\Request;
use App\Providers\NotificationService;
use Carbon\Carbon;

class TugasController extends Controller
{
    public function index()
    {
        $tugas = Tugas::with('penugasan.user')
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('admin.tugas.index', compact('tugas'));
    }

    public function create()
    {
        return view('admin.tugas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_tugas' => 'required',
            'tanggal' => 'required|date',
            'lokasi' => 'required',
            'durasi' => 'required|integer|min:1',
            'prioritas' => 'required|in:rendah,sedang,tinggi,urgent',
            'keterangan' => 'nullable',
            'auto_assign' => 'boolean',
        ]);

        $tugas = Tugas::create([
            'nama_tugas' => $validated['nama_tugas'],
            'tanggal' => $validated['tanggal'],
            'lokasi' => $validated['lokasi'],
            'durasi' => $validated['durasi'],
            'prioritas' => $validated['prioritas'],
            'keterangan' => $validated['keterangan'] ?? null,
            'status' => 'pending',
        ]);

        // Auto assign jika diminta
        if ($request->auto_assign) {
            $result = $this->autoAssign($tugas);

            if ($result) {
                return redirect()->route('admin.tugas.index')
                    ->with('success', 'Tugas berhasil ditambahkan dan ditugaskan ke ' . $result->name);
            } else {
                return redirect()->route('admin.tugas.index')
                    ->with('warning', 'Tugas berhasil ditambahkan tetapi tidak ada pegawai yang tersedia untuk ditugaskan');
            }
        }

        return redirect()->route('admin.tugas.index')
            ->with('success', 'Tugas berhasil ditambahkan');
    }

    public function edit(Tugas $tugas)
    {
        return view('admin.tugas.edit', compact('tugas'));
    }

    public function update(Request $request, Tugas $tugas)
    {
        $validated = $request->validate([
            'nama_tugas' => 'required',
            'tanggal' => 'required|date',
            'lokasi' => 'required',
            'durasi' => 'required|integer|min:1',
            'prioritas' => 'required|in:rendah,sedang,tinggi,urgent',
            'status' => 'required|in:pending,assigned,selesai,dibatalkan',
            'keterangan' => 'nullable',
        ]);

        $tugas->update($validated);

        return redirect()->route('admin.tugas.index')
            ->with('success', 'Tugas berhasil diperbarui');
    }

    public function destroy(Tugas $tugas)
    {
        $tugas->delete();
        return redirect()->route('admin.tugas.index')
            ->with('success', 'Tugas berhasil dihapus');
    }

    public function assign(Tugas $tugas)
    {
        $result = $this->autoAssign($tugas);

        if ($result) {
            return redirect()->route('admin.tugas.index')
                ->with('success', 'Tugas berhasil ditugaskan ke ' . $result->name);
        }

        return redirect()->route('admin.tugas.index')
            ->with('error', 'Tidak ada pegawai yang tersedia. Semua pegawai sudah mencapai batas maksimal tugas.');
    }

    public function show(Tugas $tugas)
    {
        $tugas->load('penugasan.user');
        return view('admin.tugas.show', compact('tugas'));
    }

    private function autoAssign(Tugas $tugas)
    {
        $queue = RoundRobinQueue::getNextAvailable();

        if (!$queue) {
            return false;
        }

        // ✅ Ambil user
        $user = $queue->user;

        if (!$user) {
            return false;
        }

        // ✅ Buat penugasan
        $penugasan = Penugasan::create([
            'tugas_id'    => $tugas->id,
            'user_id'     => $user->id,
            'assigned_at' => now(),
            'status'      => 'assigned'
        ]);

        if (!$penugasan) {
            return false;
        }

        // ✅ Update tugas
        $tugas->update([
            'status' => 'assigned'
        ]);

        // ✅ Update queue
        $queue->increment('total_assigned');
        $queue->update([
            'last_assigned_at' => now()
        ]);

        $queue->rotate();

        // ✅ Kirim notifikasi
        NotificationService::taskAssigned(
            $user,
            $tugas, 
            $penugasan
        );

        return $user;
    }


    public function assignManual(Request $request, Tugas $tugas)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::find($validated['user_id']);

        // Cek apakah pegawai bisa menerima tugas
        if (!$user->canReceiveTask()) {
            return back()->with('error', 'Pegawai sudah mencapai batas maksimal tugas');
        }

        // Create penugasan
        $penugasan = Penugasan::create([
            'tugas_id' => $tugas->id,
            'user_id' => $user->id,
            'assigned_at' => Carbon::now(),
        ]);

        $tugas->update(['status' => 'assigned']);

        // ✅ KIRIM NOTIFIKASI
        NotificationService::taskAssigned($user, $tugas, $penugasan);


        // Update queue statistics
        $queue = RoundRobinQueue::where('user_id', $user->id)->first();
        if ($queue) {
            $queue->total_assigned += 1;
            $queue->last_assigned_at = Carbon::now();
            $queue->save();
        }

        return redirect()->route('admin.tugas.index')
            ->with('success', 'Tugas berhasil ditugaskan ke ' . $user->name);
    }
}
