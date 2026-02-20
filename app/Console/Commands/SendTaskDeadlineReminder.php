<?php

namespace App\Console\Commands;

use App\Models\Penugasan;
use App\Models\Tugas;
use App\Providers\NotificationService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendTaskDeadlineReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:deadline-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send deadline reminders for tasks that are due soon';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for upcoming task deadlines...');

        // Cek tugas yang akan deadline dalam 3 hari
        $threeDaysFromNow = Carbon::now()->addDays(3)->startOfDay();
        $penugasan3Days = Penugasan::whereHas('tugas', function ($query) use ($threeDaysFromNow) {
                $query->where('status', '!=', 'completed')
                    ->where('status', '!=', 'cancelled')
                    ->whereDate('tanggal', $threeDaysFromNow);
            })
            ->with(['user', 'tugas'])
            ->get();

        foreach ($penugasan3Days as $penugasan) {
            if ($penugasan->user && $penugasan->tugas) {
                NotificationService::taskDeadlineReminder(
                    $penugasan->user,
                    $penugasan->tugas,
                    3
                );
                $this->info("✓ Reminder sent to {$penugasan->user->name} for: {$penugasan->tugas->nama_tugas} (3 days)");
            }
        }

        // Cek tugas yang akan deadline besok
        $tomorrow = Carbon::now()->addDay()->startOfDay();
        $penugasan1Day = Penugasan::whereHas('tugas', function ($query) use ($tomorrow) {
                $query->where('status', '!=', 'completed')
                    ->where('status', '!=', 'cancelled')
                    ->whereDate('tanggal', $tomorrow);
            })
            ->with(['user', 'tugas'])
            ->get();

        foreach ($penugasan1Day as $penugasan) {
            if ($penugasan->user && $penugasan->tugas) {
                NotificationService::taskDeadlineReminder(
                    $penugasan->user,
                    $penugasan->tugas,
                    1
                );
                $this->info("✓ Reminder sent to {$penugasan->user->name} for: {$penugasan->tugas->nama_tugas} (1 day)");
            }
        }

        // Cek tugas yang sudah lewat deadline (overdue)
        $yesterday = Carbon::now()->subDay()->startOfDay();
        $penugasanOverdue = Penugasan::whereHas('tugas', function ($query) use ($yesterday) {
                $query->where('status', '!=', 'completed')
                    ->where('status', '!=', 'cancelled')
                    ->whereDate('tanggal', '<', $yesterday);
            })
            ->with(['user', 'tugas'])
            ->get();

        foreach ($penugasanOverdue as $penugasan) {
            if ($penugasan->user && $penugasan->tugas) {
                $daysOverdue = Carbon::now()->diffInDays($penugasan->tugas->tanggal);
                
                NotificationService::create(
                    user: $penugasan->user,
                    title: 'Tugas Terlambat!',
                    message: "Tugas '{$penugasan->tugas->nama_tugas}' sudah terlambat {$daysOverdue} hari",
                    type: 'danger',
                    url: route('pegawai.jadwal')
                );

                // Notifikasi ke admin juga
                NotificationService::notifyAdmin(
                    title: 'Tugas Terlambat',
                    message: "{$penugasan->user->name} memiliki tugas terlambat: {$penugasan->tugas->nama_tugas}",
                    type: 'danger',
                    url: route('admin.penjadwalan.index')
                );

                $this->warn("⚠ Overdue notification sent for: {$penugasan->tugas->nama_tugas} ({$daysOverdue} days late)");
            }
        }

        $totalSent = $penugasan3Days->count() + $penugasan1Day->count() + $penugasanOverdue->count();
        
        $this->newLine();
        $this->info("═══════════════════════════════════════");
        $this->info("Total reminders sent: {$totalSent}");
        $this->info("  - 3 days reminders: {$penugasan3Days->count()}");
        $this->info("  - 1 day reminders: {$penugasan1Day->count()}");
        $this->info("  - Overdue alerts: {$penugasanOverdue->count()}");
        $this->info("═══════════════════════════════════════");

        return 0;
    }
}