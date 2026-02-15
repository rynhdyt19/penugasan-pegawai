<?php
// ============================================
// BUAT FILE: app/Http/Controllers/Pegawai/SettingsController.php
// ============================================

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    /**
     * Tampilkan halaman settings
     */
    public function index()
    {
        $user = Auth::user();
        
        // Statistik user
        $statistik = [
            'total_tugas' => $user->penugasan()->count(),
            'tugas_selesai' => $user->penugasan()->whereHas('tugas', function($q) {
                $q->where('status', 'selesai');
            })->count(),
            'total_jam' => $user->penugasan()->with('tugas')->get()->sum(function($p) {
                return $p->tugas->durasi ?? 0;
            }),
            'tugas_bulan_ini' => $user->tugasBulanan(),
            'tugas_minggu_ini' => $user->tugasMingguan(),
        ];

        return view('pegawai.settings.index', compact('statistik'));
    }

    /**
     * Update profil
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'kontak' => 'required|string|max:20',
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Update password
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
     * Update foto profil
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
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
     * Update notifikasi preferences
     */
    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        
        $preferences = [
            'email_notifications' => $request->boolean('email_notifications'),
            'task_reminders' => $request->boolean('task_reminders'),
            'weekly_summary' => $request->boolean('weekly_summary'),
        ];

        $user->update([
            'notification_preferences' => json_encode($preferences)
        ]);

        return back()->with('success', 'Preferensi notifikasi berhasil diperbarui');
    }

    /**
     * Update tema/appearance
     */
    public function updateAppearance(Request $request)
    {
        $validated = $request->validate([
            'theme' => 'required|in:light,dark,auto',
            'language' => 'required|in:id,en',
        ]);

        $user = Auth::user();
        
        $user->update([
            'preferences' => json_encode([
                'theme' => $validated['theme'],
                'language' => $validated['language'],
            ])
        ]);

        return back()->with('success', 'Pengaturan tampilan berhasil diperbarui');
    }
}