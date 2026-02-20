<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil notifikasi dengan pagination - LANGSUNG dari model Notification
        $notifications = Notification::where('user_id', $user->id)
            ->latest()
            ->paginate(20);

        // Hitung notifikasi belum dibaca
        $unreadCount = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

        // Tentukan view berdasarkan role
        $view = $user->role === 'admin'
            ? 'admin.notifications.index'
            : 'pegawai.notifications.index';

        return view($view, compact('notifications', 'unreadCount'));
    }

    /**
     * Get notifications for dropdown (AJAX).
     */
    public function fetch()
    {
        $userId = auth()->id();

        // AMBIL HANYA YANG BELUM DIBACA (is_read = false)
        $notifications = Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->latest()
            ->limit(10)
            ->get();

        $unreadCount = Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $notification->update([
            'is_read' => true,
            'read_at' => now()
        ]);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Notifikasi ditandai sebagai sudah dibaca',
            ]);
        }

        if ($notification->url) {
            return redirect($notification->url);
        }

        return redirect()->back()->with('success', 'Notifikasi ditandai sebagai sudah dibaca');
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi ditandai sebagai sudah dibaca',
        ]);
    }

    /**
     * Delete a notification.
     */
    public function destroy($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $notification->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Notifikasi berhasil dihapus',
            ]);
        }

        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus');
    }

    /**
     * Delete all read notifications.
     */
    public function deleteAllRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', true)
            ->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Semua notifikasi yang sudah dibaca berhasil dihapus',
            ]);
        }

        return redirect()->back()->with('success', 'Semua notifikasi yang sudah dibaca berhasil dihapus');
    }
}
