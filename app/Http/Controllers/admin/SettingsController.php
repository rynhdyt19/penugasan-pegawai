<?php
// ============================================
// BUAT FILE: app/Http/Controllers/Admin/SettingsController.php
// ============================================

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    /**
     * Tampilkan halaman settings untuk Admin
     */
    public function index()
    {
        $user = Auth::user();

        // Statistik admin
        $statistik = [
            'total_pegawai' => \App\Models\User::where('role', 'pegawai')->count(),
            'total_tugas' => \App\Models\Tugas::count(),
            'tugas_aktif' => \App\Models\Tugas::where('status', 'aktif')->count(),
            'tugas_selesai' => \App\Models\Tugas::where('status', 'selesai')->count(),
            'total_jam_tugas' => \App\Models\Tugas::sum('durasi'),
        ];

        return view('admin.settings.index', compact('statistik'));
    }

    /**
     * Update profil admin
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'kontak' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Update password admin
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $user = Auth::user();

        // Check current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
        }

        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        return back()->with('success', 'Password berhasil diubah');
    }

    /**
     * Update foto profil admin
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = Auth::user();

        // Delete old photo if exists
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        // Store new photo
        $path = $request->file('photo')->store('profile-photos', 'public');

        $user->update(['photo' => $path]);

        return back()->with('success', 'Foto profil berhasil diperbarui');
    }

    /**
     * Delete foto profil
     */
    public function deletePhoto()
    {
        $user = Auth::user();

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
            $user->update(['photo' => null]);
        }

        return back()->with('success', 'Foto profil berhasil dihapus');
    }

    /**
     * Update system settings (khusus admin)
     */
    public function updateSystemSettings(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'timezone' => 'required|string',
            'date_format' => 'required|string',
        ]);

        // Save to config or database
        // Implementasi sesuai kebutuhan sistem Anda

        return back()->with('success', 'Pengaturan sistem berhasil diperbarui');
    }
}
