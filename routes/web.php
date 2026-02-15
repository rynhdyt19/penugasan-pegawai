<?php

// ============================================
// routes/web.php
// ============================================

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\TugasController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PenjadwalanController;
use App\Http\Controllers\Pegawai\DashboardController as PegawaiDashboard;
use App\Http\Controllers\Pegawai\SettingsController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Middleware;

// ============================================
// PUBLIC ROUTES
// ============================================

// Redirect root ke login
Route::get('/', function () {
    return redirect('/login');
});

// ============================================
// AUTHENTICATION ROUTES
// ============================================

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============================================
// ADMIN ROUTES - Protected by auth middleware
// ============================================

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // ============================================
    // PEGAWAI MANAGEMENT
    // ============================================
    Route::prefix('pegawai')->name('pegawai.')->group(function () {
        Route::get('/', [PegawaiController::class, 'index'])->name('index');
        Route::get('/create', [PegawaiController::class, 'create'])->name('create');
        Route::post('/', [PegawaiController::class, 'store'])->name('store');
        Route::get('/{pegawai}', [PegawaiController::class, 'show'])->name('show');
        Route::get('/{pegawai}/edit', [PegawaiController::class, 'edit'])->name('edit');
        Route::put('/{pegawai}', [PegawaiController::class, 'update'])->name('update');
        Route::delete('/{pegawai}', [PegawaiController::class, 'destroy'])->name('destroy');
    });

    // ============================================
    // TUGAS MANAGEMENT
    // ============================================
    Route::prefix('tugas')->name('tugas.')->group(function () {
        Route::get('/', [TugasController::class, 'index'])->name('index');
        Route::get('/create', [TugasController::class, 'create'])->name('create');
        Route::post('/', [TugasController::class, 'store'])->name('store');
        Route::get('/{tugas}', [TugasController::class, 'show'])->name('show');
        Route::get('/{tugas}/edit', [TugasController::class, 'edit'])->name('edit');
        Route::put('/{tugas}', [TugasController::class, 'update'])->name('update');
        Route::delete('/{tugas}', [TugasController::class, 'destroy'])->name('destroy');

        // Assignment Routes
        Route::post('/{tugas}/assign', [TugasController::class, 'assign'])->name('assign');
        Route::post('/{tugas}/assign-manual', [TugasController::class, 'assignManual'])->name('assign.manual');
    });

    //PENJADWALAN
    Route::prefix('penjadwalan')->name('penjadwalan.')->group(function () {
        Route::get('/', [PenjadwalanController::class, 'index'])->name('index');
        Route::post('/run-scheduler', [PenjadwalanController::class, 'runScheduler'])->name('run');
        Route::post('/assign-manual', [PenjadwalanController::class, 'assignManual'])->name('assign.manual');
        Route::post('/reset-queue', [PenjadwalanController::class, 'resetQueue'])->name('reset-queue');
        Route::post('/update-settings', [PenjadwalanController::class, 'updateSettings'])->name('update-settings');
        Route::post('/unassign/{tugas}', [PenjadwalanController::class, 'unassign'])->name('unassign');
    });

    // ============================================
    // SETTINGS ADMIN
    // ============================================
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [AdminSettingsController::class, 'index'])->name('index');
        Route::put('/profile', [AdminSettingsController::class, 'updateProfile'])->name('update-profile');
        Route::put('/password', [AdminSettingsController::class, 'updatePassword'])->name('update-password');
        Route::post('/photo', [AdminSettingsController::class, 'updatePhoto'])->name('update-photo');
        Route::delete('/photo', [AdminSettingsController::class, 'deletePhoto'])->name('delete-photo');
        Route::put('/notifications', [AdminSettingsController::class, 'updateNotifications'])->name('update-notifications');
        Route::put('/appearance', [AdminSettingsController::class, 'updateAppearance'])->name('update-appearance');
        Route::put('/system', [AdminSettingsController::class, 'updateSystemSettings'])->name('update-system');
    });

    // ============================================
    // LAPORAN & MONITORING
    // ============================================
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/rekap-penugasan', [LaporanController::class, 'rekapPenugasan'])->name('rekap');
        Route::get('/statistik', [LaporanController::class, 'statistikBebanKerja'])->name('statistik');
        Route::get('/detail-pegawai/{pegawai}', [LaporanController::class, 'detailPegawai'])->name('detail-pegawai');

        // Export Routes
        Route::get('/export-pdf', [LaporanController::class, 'exportPDF'])->name('pdf');
        Route::get('/export-excel', [LaporanController::class, 'exportExcel'])->name('excel');
    });
});

// ============================================
// PEGAWAI ROUTES - Protected by auth and role check
// ============================================

Route::middleware(['auth', 'check.role:pegawai'])->prefix('pegawai')->name('pegawai.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [PegawaiDashboard::class, 'index'])->name('dashboard');

    // Jadwal Tugas
    Route::get('/jadwal-tugas', [PegawaiDashboard::class, 'jadwalTugas'])->name('jadwal');

    // Riwayat Tugas
    Route::get('/riwayat-tugas', [PegawaiDashboard::class, 'riwayatTugas'])->name('riwayat');

    // Detail Tugas
    Route::get('/tugas/{tugas}', [PegawaiDashboard::class, 'detailTugas'])->name('tugas.detail');

    // Profil
    Route::get('/profil', [PegawaiDashboard::class, 'profil'])->name('profil');
    Route::put('/profil/update', [PegawaiDashboard::class, 'updateProfil'])->name('profil.update');

    //settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::put('/profile', [SettingsController::class, 'updateProfile'])->name('update-profile');
        Route::put('/password', [SettingsController::class, 'updatePassword'])->name('update-password');
        Route::post('/photo', [SettingsController::class, 'updatePhoto'])->name('update-photo');
        Route::delete('/photo', [SettingsController::class, 'deletePhoto'])->name('delete-photo');
        Route::put('/notifications', [SettingsController::class, 'updateNotifications'])->name('update-notifications');
        Route::put('/appearance', [SettingsController::class, 'updateAppearance'])->name('update-appearance');
    });
});
