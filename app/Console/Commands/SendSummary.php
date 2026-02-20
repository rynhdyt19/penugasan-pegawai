<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Penugasan;
use App\Providers\NotificationService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendDailySummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:daily-summary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily summary notifications to all pegawai';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating daily summaries...');

        $today = Carbon::today();
        $pegawai = User::where('role', 'pegawai')->get();

        foreach ($pegawai as $user) {
            // Hitung statistik untuk hari ini
            $newTasks = Penugasan::where('user_id', $user->id)
                ->whereDate('assigned_at', $today)
                ->count();

            $completedTasks = Penugasan::where('user_id', $user->id)
                ->whereHas('tugas', function ($query) use ($today) {
                    $query->where('status', 'completed')
                        ->whereDate('updated_at', $today);
                })
                ->count();

            $pendingTasks = Penugasan::where('user_id', $user->id)
                ->whereHas('tugas', function ($query) {
                    $query->whereIn('status', ['pending', 'assigned', 'in_progress']);
                })
                ->count();

            // Kirim notifikasi jika ada aktivitas
            if ($newTasks > 0 || $completedTasks > 0 || $pendingTasks > 0) {
                NotificationService::dailySummary($user, [
                    'new_tasks' => $newTasks,
                    'completed_tasks' => $completedTasks,
                    'pending_tasks' => $pendingTasks
                ]);

                $this->info("✓ Summary sent to {$user->name}: New: {$newTasks}, Completed: {$completedTasks}, Pending: {$pendingTasks}");
            }
        }

        // Kirim summary ke admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $totalNewTasks = Penugasan::whereDate('assigned_at', $today)->count();
            $totalCompleted = Penugasan::whereHas('tugas', function ($query) use ($today) {
                $query->where('status', 'completed')
                    ->whereDate('updated_at', $today);
            })->count();
            $totalPending = Penugasan::whereHas('tugas', function ($query) {
                $query->whereIn('status', ['pending', 'assigned', 'in_progress']);
            })->count();

            NotificationService::create(
                user: $admin,
                title: 'Ringkasan Harian Sistem',
                message: "Hari ini: {$totalNewTasks} tugas baru, {$totalCompleted} tugas selesai, {$totalPending} tugas aktif",
                type: 'info',
                url: route('admin.dashboard')
            );

            $this->info("✓ Admin summary sent to {$admin->name}");
        }

        $this->newLine();
        $this->info('Daily summaries sent successfully!');

        return 0;
    }
}