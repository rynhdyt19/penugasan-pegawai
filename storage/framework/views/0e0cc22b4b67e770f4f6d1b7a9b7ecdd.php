

<?php $__env->startSection('title', 'Riwayat Tugas'); ?>
<?php $__env->startSection('header_title', 'Arsip Aktivitas'); ?>

<?php $__env->startSection('content'); ?>
    <div class="p-6 max-w-7xl mx-auto">
        <div class="mb-10">
            <h2 class="text-3xl font-black text-gray-900 tracking-tight">Riwayat Tugas</h2>
            <p class="text-sm font-medium text-gray-500 mt-1">Pantau semua aktivitas dan pencapaian kerja Anda.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div
                class="bg-indigo-600 rounded-[2rem] p-6 text-white shadow-lg shadow-indigo-100 hover:scale-[1.02] transition-transform">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-100">Total Tugas</p>
                <div class="flex items-end justify-between mt-2">
                    <p class="text-4xl font-black"><?php echo e($totalTugas); ?></p>
                    <span class="text-2xl opacity-50">📂</span>
                </div>
            </div>

            <div
                class="bg-emerald-500 rounded-[2rem] p-6 text-white shadow-lg shadow-emerald-100 hover:scale-[1.02] transition-transform">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-100">Total Jam Kerja</p>
                <div class="flex items-end justify-between mt-2">
                    <p class="text-4xl font-black"><?php echo e($totalJam); ?> <span class="text-lg font-medium">Jam</span></p>
                    <span class="text-2xl opacity-50">⏱️</span>
                </div>
            </div>

            <div
                class="bg-amber-500 rounded-[2rem] p-6 text-white shadow-lg shadow-amber-100 hover:scale-[1.02] transition-transform">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-amber-100">Rata-rata Bulanan</p>
                <div class="flex items-end justify-between mt-2">
                    <p class="text-4xl font-black"><?php echo e($totalTugas > 0 ? round($totalTugas / 12, 1) : 0); ?></p>
                    <span class="text-2xl opacity-50">📊</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] border border-gray-100 p-6 shadow-sm mb-8">
            <form method="GET" action="<?php echo e(route('pegawai.riwayat')); ?>"
                class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Status
                        Tugas</label>
                    <select name="status"
                        class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-indigo-500 transition-all">
                        <option value="">Semua Status</option>
                        <option value="pending" <?php echo e($status == 'pending' ? 'selected' : ''); ?>>Tertunda</option>
                        <option value="assigned" <?php echo e($status == 'assigned' ? 'selected' : ''); ?>>Ditugaskan</option>
                        <option value="selesai" <?php echo e($status == 'selesai' ? 'selected' : ''); ?>>Selesai</option>
                        <option value="dibatalkan" <?php echo e($status == 'dibatalkan' ? 'selected' : ''); ?>>Dibatalkan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Pilih
                        Bulan</label>
                    <select name="bulan"
                        class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-indigo-500 transition-all">
                        <option value="">Semua Bulan</option>
                        <?php for($i = 1; $i <= 12; $i++): ?>
                            <option value="<?php echo e($i); ?>" <?php echo e($bulan == $i ? 'selected' : ''); ?>>
                                <?php echo e(Carbon\Carbon::create()->month($i)->translatedFormat('F')); ?>

                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Pilih
                        Tahun</label>
                    <select name="tahun"
                        class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-indigo-500 transition-all">
                        <option value="">Semua Tahun</option>
                        <?php for($i = date('Y'); $i >= date('Y') - 5; $i--): ?>
                            <option value="<?php echo e($i); ?>" <?php echo e($tahun == $i ? 'selected' : ''); ?>><?php echo e($i); ?>

                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black text-[10px] uppercase tracking-[0.2em] py-3.5 rounded-xl shadow-lg shadow-indigo-100 transition-all active:scale-95">
                    Terapkan Filter
                </button>
            </form>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                Info Tugas</th>
                            <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                Waktu & Lokasi</th>
                            <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                Prioritas</th>
                            <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                Status</th>
                            <th
                                class="px-8 py-5 text-right text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <?php $__empty_1 = true; $__currentLoopData = $riwayat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $penugasan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php $tugas = $penugasan->tugas; ?>
                            <tr class="group hover:bg-indigo-50/30 transition-colors">
                                <td class="px-8 py-6">
                                    <p
                                        class="text-sm font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">
                                        <?php echo e($tugas->nama_tugas); ?></p>
                                    <p class="text-[10px] font-medium text-gray-400 mt-1 italic">Dibuat:
                                        <?php echo e($penugasan->assigned_at->translatedFormat('d M Y')); ?></p>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-xs font-bold text-gray-700 flex items-center gap-1.5">
                                            <span class="text-indigo-400">📅</span>
                                            <?php echo e($tugas->tanggal->translatedFormat('d M Y')); ?>

                                        </span>
                                        <span class="text-[11px] font-medium text-gray-500 flex items-center gap-1.5">
                                            <span class="text-indigo-400">📍</span> <?php echo e($tugas->lokasi); ?>

                                        </span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span
                                        class="px-3 py-1 text-[9px] font-black uppercase rounded-lg <?php echo e($tugas->prioritas_color); ?>">
                                        <?php echo e($tugas->prioritas); ?>

                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <span
                                        class="px-3 py-1 text-[9px] font-black uppercase rounded-lg <?php echo e($tugas->status_color); ?>">
                                        <?php echo e($tugas->status); ?>

                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <a href="<?php echo e(route('pegawai.tugas.detail', $tugas)); ?>"
                                        class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gray-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Belum ada data
                                            riwayat</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8">
            <?php echo e($riwayat->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\penugasan-pegawai\resources\views/pegawai/riwayat-tugas.blade.php ENDPATH**/ ?>