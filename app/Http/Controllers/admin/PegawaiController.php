<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\RoundRobinQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = User::where('role', 'pegawai')
            ->withCount('penugasan')
            ->paginate(10);
        
        return view('admin.pegawai.index', compact('pegawai'));
    }

    public function create()
    {
        return view('admin.pegawai.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:users',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'jabatan' => 'required',
            'seksi' => 'required',
            'kontak' => 'required',
            'max_tugas_mingguan' => 'required|integer|min:1',
            'max_tugas_bulanan' => 'required|integer|min:1',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'pegawai';

        $user = User::create($validated);

        // Tambahkan ke round robin queue
        RoundRobinQueue::create([
            'user_id' => $user->id,
            'position' => RoundRobinQueue::count(),
            'total_assigned' => 0,
        ]);

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Pegawai berhasil ditambahkan');
    }

    public function edit(User $pegawai)
    {
        return view('admin.pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, User $pegawai)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:users,nip,' . $pegawai->id,
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $pegawai->id,
            'jabatan' => 'required',
            'seksi' => 'required',
            'kontak' => 'required',
            'max_tugas_mingguan' => 'required|integer|min:1',
            'max_tugas_bulanan' => 'required|integer|min:1',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $pegawai->update($validated);

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Pegawai berhasil diperbarui');
    }

    public function destroy(User $pegawai)
    {
        $pegawai->delete();
        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Pegawai berhasil dihapus');
    }

    public function show(User $pegawai)
    {
        $pegawai->load(['penugasan.tugas']);
        
        $statistik = [
            'total_tugas' => $pegawai->penugasan->count(),
            'tugas_aktif' => $pegawai->penugasan->whereIn('tugas.status', ['assigned', 'pending'])->count(),
            'tugas_selesai' => $pegawai->penugasan->where('tugas.status', 'selesai')->count(),
            'total_jam' => $pegawai->penugasan->sum(function($p) {
                return $p->tugas->durasi ?? 0;
            }),
        ];

        return view('admin.pegawai.show', compact('pegawai', 'statistik'));
    }
}