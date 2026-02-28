

<?php $__env->startSection('title', 'Penjadwalan & Assignment'); ?>
<?php $__env->startSection('header_title', 'Manajemen Penjadwalan'); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="flex items-center p-4 mb-4 text-green-800 rounded-2xl bg-green-50 border border-green-100 animate-in slide-in-from-top duration-300"
            role="alert">
            <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd"></path>
            </svg>
            <div class="ml-3 text-sm font-bold"><?php echo e(session('success')); ?></div>
        </div>
    <?php endif; ?>

    <?php if(session('warning')): ?>
        <div class="flex items-center p-4 mb-4 text-amber-800 rounded-2xl bg-amber-50 border border-amber-100 animate-in slide-in-from-top duration-300"
            role="alert">
            <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd"></path>
            </svg>
            <div class="ml-3 text-sm font-bold"><?php echo e(session('warning')); ?></div>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="flex items-center p-4 mb-4 text-red-800 rounded-2xl bg-red-50 border border-red-100 animate-in slide-in-from-top duration-300"
            role="alert">
            <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                    clip-rule="evenodd"></path>
            </svg>
            <div class="ml-3 text-sm font-bold"><?php echo e(session('error')); ?></div>
        </div>
    <?php endif; ?>
    <div class="space-y-8 animate-in fade-in duration-500">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Penjadwalan & Assignment</h1>
                <p class="text-sm text-gray-500 flex items-center mt-1">
                    <span class="flex h-2 w-2 rounded-full bg-indigo-500 mr-2"></span>
                    Sistem optimasi penugasan berbasis Round Robin Algorithm
                </p>
            </div>
            <div class="flex items-center gap-3">
                <form action="<?php echo e(route('admin.penjadwalan.reset-queue')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" onclick="return confirm('Reset antrean?')"
                        class="group inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-all shadow-sm">
                        <svg class="w-4 h-4 group-hover:rotate-180 transition-transform duration-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                        Reset Queue
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php
                $statConfig = [
                    ['total_pegawai', 'Total Pegawai', 'blue', 'M17 20h5v-2a3 3 0 00-5.356-1.857...'],
                    ['pegawai_available', 'Tersedia', 'green', 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0...'],
                    ['tugas_pending', 'Pending', 'yellow', 'M12 8v4l3 3m6-3a9 9 0 11-18 0...'],
                    ['avg_beban', 'Rata-rata Beban', 'purple', 'M9 19v-6a2 2 0 00-2-2H5a2...'],
                ];
            ?>

            <?php $__currentLoopData = [['label' => 'Total Pegawai', 'val' => $stats['total_pegawai'], 'color' => 'blue', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'], ['label' => 'Tersedia', 'val' => $stats['pegawai_available'], 'color' => 'green', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'], ['label' => 'Tugas Pending', 'val' => $stats['tugas_pending'], 'color' => 'amber', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'], ['label' => 'Rata Beban', 'val' => number_format($stats['avg_beban'], 1) . '%', 'color' => 'indigo', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="p-2.5 bg-<?php echo e($item['color']); ?>-50 rounded-xl text-<?php echo e($item['color']); ?>-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="<?php echo e($item['icon']); ?>"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-gray-900"><?php echo e($item['val']); ?></span>
                    </div>
                    <p class="mt-4 text-sm font-medium text-gray-500 uppercase tracking-wider"><?php echo e($item['label']); ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div class="xl:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4">
                    <form method="GET" action="<?php echo e(route('admin.penjadwalan.index')); ?>"
                        class="flex flex-wrap items-center gap-4">

                        <div class="flex-1 min-w-[200px]">
                            <label
                                class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 ml-1">Pilih
                                Bulan</label>
                            <div class="relative group">
                                <select name="bulan"
                                    class="w-full appearance-none bg-white border border-gray-200 rounded-2xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:ring-4 focus:ring-blue-50 focus:border-blue-400 transition-all cursor-pointer shadow-sm">
                                    <?php for($i = 1; $i <= 12; $i++): ?>
                                        <option value="<?php echo e($i); ?>" <?php echo e($bulan == $i ? 'selected' : ''); ?>>
                                            <?php echo e(DateTime::createFromFormat('!m', $i)->format('F')); ?>

                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-blue-500 transition-transform group-focus-within:rotate-180"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="flex-1 min-w-[200px]">
                            <label
                                class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 ml-1">Seksi
                                / Bagian</label>
                            <div class="relative group">
                                <select name="seksi"
                                    class="w-full appearance-none bg-white border border-gray-200 rounded-2xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:ring-4 focus:ring-blue-50 focus:border-blue-400 transition-all cursor-pointer shadow-sm">
                                    <option value="">Semua Bagian</option>
                                    <?php $__currentLoopData = $seksiList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($s); ?>" <?php echo e($seksi == $s ? 'selected' : ''); ?>>
                                            <?php echo e($s); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-blue-500 transition-transform group-focus-within:rotate-180"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-end h-full pt-5">
                            <button type="submit"
                                class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-2xl transition-all shadow-lg shadow-blue-100 active:scale-95">
                                Terapkan Filter
                            </button>
                        </div>
                    </form>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php $__currentLoopData = $pegawai->sortBy('persentase_beban'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div
                            class="bg-white rounded-2xl border border-gray-200 p-5 hover:border-indigo-300 transition-all group">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($p->name)); ?>&background=EEF2FF&color=4F46E5&bold=true"
                                            class="w-12 h-12 rounded-2xl shadow-sm">
                                        <div
                                            class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white <?php echo e($p->canReceiveTask() ? 'bg-green-500' : 'bg-red-500'); ?>">
                                        </div>
                                    </div>
                                    <div>
                                        <h4
                                            class="text-sm font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">
                                            <?php echo e($p->name); ?></h4>
                                        <p class="text-xs text-gray-500 font-medium uppercase tracking-tighter">
                                            <?php echo e($p->seksi); ?></p>
                                    </div>
                                </div>
                                <button
                                    onclick="openSettingsModal(<?php echo e($p->id); ?>, '<?php echo e($p->name); ?>', <?php echo e($p->max_tugas_mingguan); ?>, <?php echo e($p->max_tugas_bulanan); ?>)"
                                    class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                                        </path>
                                    </svg>
                                </button>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <div
                                        class="flex justify-between text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1.5">
                                        <span>Beban Kerja</span>
                                        <span
                                            class="<?php echo e($p->persentase_beban > 80 ? 'text-red-500' : 'text-indigo-600'); ?>"><?php echo e($p->tugas_bulan_ini); ?>

                                            / <?php echo e($p->max_tugas_bulanan); ?></span>
                                    </div>
                                    <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-700 <?php echo e($p->persentase_beban >= 90 ? 'bg-red-500' : ($p->persentase_beban >= 70 ? 'bg-amber-500' : 'bg-indigo-500')); ?>"
                                            style="width: <?php echo e(min($p->persentase_beban, 100)); ?>%"></div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between pt-2 border-t border-gray-50">
                                    
                                    <span class="text-xs font-bold text-gray-700"><?php echo e($p->jam_bulan_ini); ?> Jam</span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-gray-900 rounded-3xl p-6 text-white shadow-xl shadow-indigo-100 relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="text-lg font-bold mb-1">Antrean Otomatis</h3>
                        <p class="text-xs text-indigo-300 mb-6 font-medium">Prioritas penugasan berikutnya</p>

                        <div class="space-y-3">
                            <?php $__currentLoopData = $queueStats->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $queue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div
                                    class="flex items-center gap-3 p-3 bg-white/10 rounded-2xl backdrop-blur-md border border-white/5 group hover:bg-white/20 transition-all">
                                    <span
                                        class="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-lg bg-indigo-500 text-[10px] font-black italic">#<?php echo e($loop->iteration); ?></span>
                                    <span
                                        class="flex-1 text-sm font-medium truncate"><?php echo e($queue->user->name ?? 'N/A'); ?></span>
                                    <div
                                        class="w-2 h-2 rounded-full <?php echo e($queue->user && $queue->user->canReceiveTask() ? 'bg-green-400' : 'bg-red-400'); ?>">
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-indigo-500/20 rounded-full blur-3xl"></div>
                </div>

                <div class="bg-white rounded-3xl border border-gray-200 shadow-sm flex flex-col h-[500px]">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="font-bold text-gray-900">Pilih Tugas</h3>
                        <p class="text-xs text-gray-500 mt-1">Checklist tugas yang ingin di-assign</p>
                    </div>

                    <form action="<?php echo e(route('admin.penjadwalan.run')); ?>" method="POST"
                        class="flex-1 flex flex-col overflow-hidden">
                        <?php echo csrf_field(); ?>
                        <div class="flex-1 overflow-y-auto p-4 space-y-3 custom-scrollbar">
                            <?php $__empty_1 = true; $__currentLoopData = $tugasPending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tugas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <label class="block relative group cursor-pointer">
                                    <input type="checkbox" name="tugas_ids[]" value="<?php echo e($tugas->id); ?>"
                                        class="peer hidden">
                                    <div
                                        class="p-4 rounded-2xl border border-gray-100 bg-gray-50 peer-checked:bg-indigo-50 peer-checked:border-indigo-200 transition-all">
                                        <div class="flex justify-between items-start mb-2">
                                            <span
                                                class="text-[10px] font-bold px-2 py-0.5 rounded-md uppercase <?php echo e($tugas->prioritas == 'tinggi' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600'); ?>">
                                                <?php echo e($tugas->prioritas); ?>

                                            </span>
                                            <div
                                                class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:bg-indigo-600 peer-checked:border-indigo-600">
                                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="text-sm font-bold text-gray-800 line-clamp-1"><?php echo e($tugas->nama_tugas); ?>

                                        </p>
                                        <div class="flex items-center gap-3 mt-2 text-[10px] font-bold text-gray-400">
                                            <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg> <?php echo e($tugas->tanggal->format('d M')); ?></span>
                                            <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg> <?php echo e($tugas->durasi); ?> Jam</span>
                                        </div>
                                    </div>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="text-center py-10">
                                    <p class="text-sm text-gray-400">Semua tugas sudah dijadwalkan ✨</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="p-6 bg-gray-50/50 border-t border-gray-100">
                            <button type="submit"
                                class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 transition-all transform hover:-translate-y-1 active:translate-y-0 disabled:opacity-50"
                                <?php echo e($tugasPending->isEmpty() ? 'disabled' : ''); ?>>
                                Jalankan Assignment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="settingsModal" class="hidden fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeSettingsModal()">
            </div>
            <div class="relative bg-white rounded-3xl shadow-2xl max-w-sm w-full p-8 transform transition-all">
                <div class="text-center mb-6">
                    <div
                        class="mx-auto w-16 h-16 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-black text-gray-900" id="modalPegawaiName"></h3>
                    <p class="text-sm text-gray-500 font-medium mt-1">Sesuaikan batas beban kerja</p>
                </div>

                <form action="<?php echo e(route('admin.penjadwalan.update-settings')); ?>" method="POST" class="space-y-5">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="user_id" id="modalUserId">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Max Tugas /
                            Minggu</label>
                        <input type="number" name="max_tugas_mingguan" id="modalMaxMingguan"
                            class="w-full px-5 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-gray-700">
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Max Tugas /
                            Bulan</label>
                        <input type="number" name="max_tugas_bulanan" id="modalMaxBulanan"
                            class="w-full px-5 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-gray-700">
                    </div>
                    <div class="flex flex-col gap-2 pt-4">
                        <button type="submit"
                            class="w-full py-4 bg-gray-900 text-white rounded-2xl font-bold hover:bg-indigo-600 transition-all">Simpan
                            Perubahan</button>
                        <button type="button" onclick="closeSettingsModal()"
                            class="w-full py-4 bg-transparent text-gray-400 font-bold hover:text-gray-600 transition-all">Batalkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        setTimeout(function() {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(alert => {
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\penugasan-pegawai\resources\views/admin/penjadwalan/index.blade.php ENDPATH**/ ?>