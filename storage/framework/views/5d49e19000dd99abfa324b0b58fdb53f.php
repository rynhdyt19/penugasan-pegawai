

<?php $__env->startSection('title', 'Detail Penugasan Pegawai'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 animate-in fade-in duration-700">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div class="flex items-center gap-5">
                <div
                    class="w-16 h-16 rounded-[2rem] bg-gradient-to-br from-indigo-600 to-violet-700 flex items-center justify-center text-white text-xl font-black shadow-xl shadow-indigo-200">
                    <?php echo e(substr($pegawai->name, 0, 2)); ?>

                </div>
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight"><?php echo e($pegawai->name); ?></h2>
                    <p class="text-gray-500 flex items-center gap-2 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Periode <?php echo e(DateTime::createFromFormat('!m', $bulan)->format('F')); ?> <?php echo e($tahun); ?>

                    </p>
                </div>
            </div>
            <a href="<?php echo e(route('admin.laporan.rekap', ['bulan' => $bulan, 'tahun' => $tahun])); ?>"
                class="inline-flex items-center px-6 py-3 bg-white border border-gray-200 text-[11px] font-black text-gray-500 rounded-2xl hover:text-indigo-600 hover:border-indigo-100 hover:bg-indigo-50 transition-all duration-300 shadow-sm uppercase tracking-[0.2em]">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div
                class="bg-white rounded-[2rem] p-7 border border-gray-100 shadow-xl shadow-gray-200/40 relative overflow-hidden group">
                <div
                    class="absolute -right-4 -top-4 w-20 h-20 bg-indigo-50 rounded-full group-hover:scale-150 transition-transform duration-700">
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Tugas</p>
                    <h4 class="text-4xl font-black text-gray-900"><?php echo e($statistik['total_tugas']); ?></h4>
                    <div
                        class="mt-4 flex items-center text-[10px] font-bold text-indigo-500 bg-indigo-50 w-fit px-3 py-1 rounded-full uppercase">
                        Penugasan
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-[2rem] p-7 border border-gray-100 shadow-xl shadow-gray-200/40 relative overflow-hidden group">
                <div
                    class="absolute -right-4 -top-4 w-20 h-20 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform duration-700">
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Akumulasi Waktu</p>
                    <h4 class="text-4xl font-black text-emerald-600"><?php echo e($statistik['total_jam']); ?><span
                            class="text-lg ml-1 text-emerald-300">Jam</span></h4>
                    <div
                        class="mt-4 flex items-center text-[10px] font-bold text-emerald-500 bg-emerald-50 w-fit px-3 py-1 rounded-full uppercase">
                        Produktivitas
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-[2rem] p-7 border border-gray-100 shadow-xl shadow-gray-200/40 relative overflow-hidden group">
                <div
                    class="absolute -right-4 -top-4 w-20 h-20 bg-purple-50 rounded-full group-hover:scale-150 transition-transform duration-700">
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Tugas Selesai</p>
                    <h4 class="text-4xl font-black text-purple-600"><?php echo e($statistik['tugas_selesai']); ?></h4>
                    <div
                        class="mt-4 flex items-center text-[10px] font-bold text-purple-500 bg-purple-50 w-fit px-3 py-1 rounded-full uppercase">
                        Achieved
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-[2rem] p-7 border border-gray-100 shadow-xl shadow-gray-200/40 relative overflow-hidden group">
                <div
                    class="absolute -right-4 -top-4 w-20 h-20 bg-amber-50 rounded-full group-hover:scale-150 transition-transform duration-700">
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Sedang Jalan</p>
                    <h4 class="text-4xl font-black text-amber-500"><?php echo e($statistik['tugas_aktif']); ?></h4>
                    <div
                        class="mt-4 flex items-center text-[10px] font-bold text-amber-600 bg-amber-50 w-fit px-3 py-1 rounded-full uppercase">
                        In Progress
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-gray-200/60 border border-gray-100 overflow-hidden">
            <div class="px-10 py-8 border-b border-gray-50 flex items-center justify-between bg-white">
                <h3 class="text-lg font-black text-gray-900 tracking-tight flex items-center gap-3">
                    Rincian Riwayat Tugas
                    <span class="px-3 py-1 bg-gray-100 text-gray-400 text-[10px] rounded-lg tracking-widest uppercase">Live
                        Data</span>
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                Detail Tugas & Lokasi</th>
                            <th
                                class="px-8 py-5 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                Waktu</th>
                            <th
                                class="px-8 py-5 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                Prioritas</th>
                            <th
                                class="px-8 py-5 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                Status</th>
                            <th
                                class="px-8 py-5 text-right text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                Tgl Penugasan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        <?php $__empty_1 = true; $__currentLoopData = $penugasan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-indigo-50/30 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-sm font-black text-gray-900 mb-1 group-hover:text-indigo-600 transition-colors"><?php echo e($p->tugas->nama_tugas); ?></span>
                                        <div class="flex items-center gap-1.5 text-gray-400">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                            </svg>
                                            <span
                                                class="text-[11px] font-medium tracking-wide italic"><?php echo e($p->tugas->lokasi); ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <div class="flex flex-col items-center">
                                        <span
                                            class="text-[11px] font-black text-gray-700"><?php echo e($p->tugas->tanggal->format('d M Y')); ?></span>
                                        <span
                                            class="text-[10px] font-bold text-gray-400 uppercase mt-0.5"><?php echo e($p->tugas->durasi); ?>

                                            Jam Kerja</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span
                                        class="px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest border border-current <?php echo e($p->tugas->prioritas_color); ?>">
                                        <?php echo e($p->tugas->prioritas); ?>

                                    </span>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span
                                        class="px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest border border-current <?php echo e($p->tugas->status_color); ?>">
                                        <?php echo e($p->tugas->status); ?>

                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right whitespace-nowrap">
                                    <span
                                        class="text-xs font-bold text-gray-400"><?php echo e($p->assigned_at->format('d/m/Y')); ?></span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-8 py-24 text-center">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                                </path>
                                            </svg>
                                        </div>
                                        <p class="text-gray-400 font-black uppercase tracking-[0.2em] text-xs">Belum ada
                                            riwayat tugas</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\penugasan-pegawai\resources\views/admin/laporan/detail-pegawai.blade.php ENDPATH**/ ?>