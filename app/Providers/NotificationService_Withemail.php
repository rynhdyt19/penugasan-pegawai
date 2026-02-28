<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\Tugas;
use App\Models\Penugasan;
use App\Mail\NotificationEmail;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    /**
     * Create a new notification and optionally send email.
     */
    public static function create(
        User $user,
        string $title,
        string $message,
        string $type = 'info',
        ?string $url = null,
        ?string $icon = null,
        bool $sendEmail = true  // Default: kirim email
    ): Notification {
        // Create notification in database
        $notification = Notification::create([
            'user_id' => $user->id,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'url' => $url,
            'icon' => $icon,
        ]);

        // Send email if enabled and user has email
        if ($sendEmail && $user->email) {
            try {
                Mail::to($user->email)->send(new NotificationEmail($user, $notification));
            } catch (\Exception $e) {
                // Log error tapi jangan stop execution
                \Log::error('Failed to send notification email: ' . $e->getMessage());
            }
        }

        return $notification;
    }

    /**
     * Send notification when new task is assigned.
     */
    public static function taskAssigned(User $user, Tugas $tugas, Penugasan $penugasan): void
    {
        $tanggal = $tugas->tanggal ? $tugas->tanggal->format('d/m/Y') : '-';

        self::create(
            user: $user,
            title: 'Tugas Baru Ditugaskan',
            message: "Anda telah ditugaskan untuk: {$tugas->nama_tugas} pada tanggal {$tanggal}",
            type: 'info',
            url: route('pegawai.jadwal'),
            sendEmail: true  // Kirim email
        );
    }

    /**
     * Send notification when task is unassigned/cancelled.
     */
    public static function taskUnassigned(User $user, Tugas $tugas): void
    {
        self::create(
            user: $user,
            title: 'Penugasan Dibatalkan',
            message: "Penugasan untuk tugas '{$tugas->nama_tugas}' telah dibatalkan",
            type: 'warning',
            url: route('pegawai.jadwal'),
            sendEmail: true
        );
    }

    /**
     * Send notification when task status is updated.
     */
    public static function taskStatusUpdated(User $user, Tugas $tugas, string $oldStatus, string $newStatus): void
    {
        $statusLabel = [
            'pending' => 'Menunggu',
            'assigned' => 'Ditugaskan',
            'in_progress' => 'Sedang Dikerjakan',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan'
        ];

        $message = "Status tugas '{$tugas->nama_tugas}' berubah dari {$statusLabel[$oldStatus]} menjadi {$statusLabel[$newStatus]}";

        $type = match ($newStatus) {
            'completed' => 'success',
            'cancelled' => 'danger',
            'in_progress' => 'info',
            default => 'warning'
        };

        self::create(
            user: $user,
            title: 'Status Tugas Berubah',
            message: $message,
            type: $type,
            url: route('pegawai.jadwal'),
            sendEmail: false  // Status update tidak perlu email
        );
    }

    /**
     * Send notification when task deadline is approaching.
     */
    public static function taskDeadlineReminder(User $user, Tugas $tugas, int $daysLeft): void
    {
        $message = $daysLeft === 1
            ? "Tugas '{$tugas->nama_tugas}' akan berakhir besok!"
            : "Tugas '{$tugas->nama_tugas}' akan berakhir dalam {$daysLeft} hari";

        self::create(
            user: $user,
            title: 'Pengingat Deadline',
            message: $message,
            type: 'warning',
            url: route('pegawai.jadwal'),
            sendEmail: true  // Reminder perlu email
        );
    }

    /**
     * Send notification when task is completed.
     */
    public static function taskCompleted(User $user, Tugas $tugas): void
    {
        self::create(
            user: $user,
            title: 'Tugas Selesai',
            message: "Selamat! Tugas '{$tugas->nama_tugas}' telah selesai dikerjakan",
            type: 'success',
            url: route('pegawai.riwayat'),
            sendEmail: true
        );
    }

    /**
     * Send notification about workload limit.
     */
    public static function workloadLimitReached(User $user): void
    {
        self::create(
            user: $user,
            title: 'Batas Beban Kerja',
            message: "Anda telah mencapai batas maksimal tugas untuk periode ini",
            type: 'warning',
            url: route('pegawai.dashboard'),
            sendEmail: false
        );
    }

    /**
     * Send welcome notification to new user.
     */
    public static function welcomeUser(User $user): void
    {
        $url = $user->role === 'admin'
            ? route('admin.dashboard')
            : route('pegawai.dashboard');

        self::create(
            user: $user,
            title: 'Selamat Datang!',
            message: "Selamat datang di Sistem Penjadwalan Pegawai BPS, {$user->name}",
            type: 'success',
            url: $url,
            sendEmail: true  // Welcome email
        );
    }

    /**
     * Notify about automatic task scheduling.
     */
    public static function autoSchedulingCompleted(User $user, int $assignedCount): void
    {
        self::create(
            user: $user,
            title: 'Penjadwalan Otomatis',
            message: "{$assignedCount} tugas baru telah dijadwalkan secara otomatis untuk Anda",
            type: 'info',
            url: route('pegawai.jadwal'),
            sendEmail: true
        );
    }

    /**
     * Notify about Round Robin queue rotation.
     */
    public static function queueRotated(User $user, int $position): void
    {
        self::create(
            user: $user,
            title: 'Posisi Queue Berubah',
            message: "Posisi Anda dalam antrian penjadwalan sekarang: #{$position}",
            type: 'info',
            url: route('pegawai.dashboard'),
            sendEmail: false  // Queue rotation tidak perlu email
        );
    }

    /**
     * Notify pegawai about their turn in queue.
     */
    public static function yourTurnInQueue(User $user): void
    {
        self::create(
            user: $user,
            title: 'Giliran Anda',
            message: "Anda berada di urutan pertama untuk menerima tugas berikutnya",
            type: 'info',
            url: route('pegawai.dashboard'),
            sendEmail: false
        );
    }

    /**
     * Notify admin about system events.
     */
    public static function notifyAdmin(string $title, string $message, string $type = 'info', ?string $url = null, bool $sendEmail = false): void
    {
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            self::create(
                user: $admin,
                title: $title,
                message: $message,
                type: $type,
                url: $url,
                sendEmail: $sendEmail  // Admin notification biasanya tidak perlu email
            );
        }
    }

    /**
     * Notify admin when all tasks are scheduled.
     */
    public static function allTasksScheduled(int $totalAssigned): void
    {
        self::notifyAdmin(
            title: 'Penjadwalan Selesai',
            message: "Penjadwalan otomatis telah selesai. Total {$totalAssigned} tugas berhasil dijadwalkan",
            type: 'success',
            url: route('admin.penjadwalan.index'),
            sendEmail: false
        );
    }

    /**
     * Notify admin when no pegawai available.
     */
    public static function noPegawaiAvailable(int $pendingTasks): void
    {
        self::notifyAdmin(
            title: 'Tidak Ada Pegawai Tersedia',
            message: "Terdapat {$pendingTasks} tugas pending namun tidak ada pegawai yang tersedia untuk menerima tugas",
            type: 'danger',
            url: route('admin.penjadwalan.index'),
            sendEmail: true  // Admin perlu tahu ini via email
        );
    }

    /**
     * Notify admin when queue is reset.
     */
    public static function queueReset(): void
    {
        self::notifyAdmin(
            title: 'Queue Direset',
            message: "Queue Round Robin telah direset ulang",
            type: 'warning',
            url: route('admin.penjadwalan.index'),
            sendEmail: false
        );
    }

    /**
     * Notify about pegawai workload settings update.
     */
    public static function workloadSettingsUpdated(User $user, int $maxMingguan, int $maxBulanan): void
    {
        self::create(
            user: $user,
            title: 'Pengaturan Beban Kerja Diperbarui',
            message: "Batas tugas Anda telah diperbarui: Mingguan: {$maxMingguan}, Bulanan: {$maxBulanan}",
            type: 'info',
            url: route('pegawai.dashboard'),
            sendEmail: true
        );
    }

    /**
     * Send bulk notification to multiple users.
     */
    public static function sendBulk(array $userIds, string $title, string $message, string $type = 'info', ?string $url = null, bool $sendEmail = false): void
    {
        foreach ($userIds as $userId) {
            $user = User::find($userId);
            if ($user) {
                self::create(
                    user: $user,
                    title: $title,
                    message: $message,
                    type: $type,
                    url: $url,
                    sendEmail: $sendEmail
                );
            }
        }
    }

    /**
     * Notify pegawai by seksi.
     */
    public static function notifyBySeksi(string $seksi, string $title, string $message, string $type = 'info', ?string $url = null, bool $sendEmail = false): void
    {
        $users = User::where('role', 'pegawai')
            ->where('seksi', $seksi)
            ->get();

        foreach ($users as $user) {
            self::create(
                user: $user,
                title: $title,
                message: $message,
                type: $type,
                url: $url,
                sendEmail: $sendEmail
            );
        }
    }

    /**
     * Send daily summary notification.
     */
    public static function dailySummary(User $user, array $summary): void
    {
        $message = "Hari ini: ";
        $parts = [];

        if (isset($summary['new_tasks'])) {
            $parts[] = "{$summary['new_tasks']} tugas baru";
        }
        if (isset($summary['completed_tasks'])) {
            $parts[] = "{$summary['completed_tasks']} tugas selesai";
        }
        if (isset($summary['pending_tasks'])) {
            $parts[] = "{$summary['pending_tasks']} tugas pending";
        }

        $message .= implode(', ', $parts);

        self::create(
            user: $user,
            title: 'Ringkasan Harian',
            message: $message,
            type: 'info',
            url: route('pegawai.dashboard'),
            sendEmail: true  // Daily summary via email
        );
    }

    /**
     * Notify about high priority task.
     */
    public static function highPriorityTask(User $user, Tugas $tugas): void
    {
        self::create(
            user: $user,
            title: 'Tugas Prioritas Tinggi!',
            message: "Tugas prioritas tinggi '{$tugas->nama_tugas}' telah ditugaskan kepada Anda. Mohon segera ditindaklanjuti.",
            type: 'danger',
            url: route('pegawai.jadwal'),
            sendEmail: true  // High priority perlu email
        );
    }
}
