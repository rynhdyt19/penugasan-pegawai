<?php

namespace App\Observers;

use App\Models\Tugas;
use App\Providers\NotificationService;

class TugasObserver
{
    /**
     * Handle the Tugas "created" event.
     */
    public function created(Tugas $tugas): void
    {
        // Notifikasi ke admin ketika tugas baru dibuat
        NotificationService::notifyAdmin(
            title: 'Tugas Baru Dibuat',
            message: "Tugas baru '{$tugas->nama_tugas}' telah ditambahkan ke sistem",
            type: 'info',
            url: route('admin.tugas.index')
        );
    }

    /**
     * Handle the Tugas "updated" event.
     */
    public function updated(Tugas $tugas): void
    {
        // Cek apakah status berubah
        if ($tugas->isDirty('status')) {
            $oldStatus = $tugas->getOriginal('status');
            $newStatus = $tugas->status;

            // Notifikasi ke pegawai yang ditugaskan
            $penugasan = $tugas->penugasan()->first();
            if ($penugasan && $penugasan->user) {
                NotificationService::taskStatusUpdated(
                    $penugasan->user,
                    $tugas,
                    $oldStatus,
                    $newStatus
                );
            }

            // Jika status berubah menjadi completed
            if ($newStatus === 'completed') {
                if ($penugasan && $penugasan->user) {
                    NotificationService::taskCompleted($penugasan->user, $tugas);
                }

                // Notifikasi ke admin
                NotificationService::notifyAdmin(
                    title: 'Tugas Selesai',
                    message: "Tugas '{$tugas->nama_tugas}' telah diselesaikan" .
                        ($penugasan ? " oleh {$penugasan->user->name}" : ""),
                    type: 'success',
                    url: route('admin.tugas.index')
                );
            }

            // Jika status berubah menjadi cancelled
            if ($newStatus === 'cancelled') {
                NotificationService::notifyAdmin(
                    title: 'Tugas Dibatalkan',
                    message: "Tugas '{$tugas->nama_tugas}' telah dibatalkan",
                    type: 'warning',
                    url: route('admin.tugas.index')
                );
            }
        }

        // Cek apakah prioritas berubah menjadi tinggi/urgent
        if ($tugas->isDirty('prioritas')) {
            $newPrioritas = $tugas->prioritas;

            if (in_array($newPrioritas, ['tinggi', 'urgent'])) {
                $penugasan = $tugas->penugasan()->first();
                if ($penugasan && $penugasan->user) {
                    NotificationService::create(
                        user: $penugasan->user,
                        title: 'Prioritas Tugas Berubah',
                        message: "Tugas '{$tugas->nama_tugas}' sekarang menjadi prioritas {$newPrioritas}!",
                        type: 'warning',
                        url: route('pegawai.jadwal')
                    );
                }
            }
        }

        // Cek apakah tanggal deadline berubah
        if ($tugas->isDirty('tanggal')) {
            $penugasan = $tugas->penugasan()->first();
            if ($penugasan && $penugasan->user) {
                $oldDate = \Carbon\Carbon::parse($tugas->getOriginal('tanggal'))->format('d/m/Y');
                $newDate = \Carbon\Carbon::parse($tugas->tanggal)->format('d/m/Y');

                NotificationService::create(
                    user: $penugasan->user,
                    title: 'Deadline Tugas Berubah',
                    message: "Deadline tugas '{$tugas->nama_tugas}' berubah dari {$oldDate} menjadi {$newDate}",
                    type: 'warning',
                    url: route('pegawai.jadwal')
                );
            }
        }
    }

    /**
     * Handle the Tugas "deleted" event.
     */
    public function deleted(Tugas $tugas): void
    {
        // Notifikasi ke pegawai yang ditugaskan
        $penugasan = $tugas->penugasan()->withTrashed()->first();
        if ($penugasan && $penugasan->user) {
            NotificationService::create(
                user: $penugasan->user,
                title: 'Tugas Dihapus',
                message: "Tugas '{$tugas->nama_tugas}' telah dihapus dari sistem",
                type: 'danger',
                url: route('pegawai.jadwal')
            );
        }

        // Notifikasi ke admin
        NotificationService::notifyAdmin(
            title: 'Tugas Dihapus',
            message: "Tugas '{$tugas->nama_tugas}' telah dihapus dari sistem",
            type: 'danger',
            url: route('admin.tugas.index')
        );
    }

    /**
     * Handle the Tugas "restored" event.
     */
    public function restored(Tugas $tugas): void
    {
        // Notifikasi ke admin
        NotificationService::notifyAdmin(
            title: 'Tugas Dipulihkan',
            message: "Tugas '{$tugas->nama_tugas}' telah dipulihkan",
            type: 'info',
            url: route('admin.tugas.index')
        );
    }
}
