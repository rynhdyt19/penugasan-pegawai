

<?php $__env->startSection('title', 'Rekap Penugasan'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 animate-in fade-in duration-700">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Rekap Penugasan</h2>
                <p class="text-gray-500 mt-1">Pantau produktivitas dan distribusi jam kerja pegawai.</p>
            </div>
            <a href="<?php echo e(route('admin.laporan.index')); ?>"
                class="inline-flex items-center px-5 py-2.5 bg-white border border-gray-200 text-sm font-bold text-gray-500 rounded-2xl hover:text-indigo-600 hover:border-indigo-100 hover:bg-indigo-50 transition-all duration-300 shadow-sm uppercase tracking-widest">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 p-8 mb-8">
            <form method="GET" action="<?php echo e(route('admin.laporan.rekap')); ?>"
                class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">

                <div class="space-y-2" x-data="{
                    open: false,
                    selected: '<?php echo e($bulan); ?>',
                    labels: {
                        '1': 'Januari',
                        '2': 'Februari',
                        '3': 'Maret',
                        '4': 'April',
                        '5': 'Mei',
                        '6': 'Juni',
                        '7': 'Juli',
                        '8': 'Agustus',
                        '9': 'September',
                        '10': 'Oktober',
                        '11': 'November',
                        '12': 'Desember'
                    }
                }">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-2">Pilih Bulan</label>
                    <div class="relative">
                        <button type="button" @click="open = !open"
                            class="w-full px-5 py-4 bg-gray-50 rounded-2xl flex items-center justify-between transition-all font-bold text-gray-700 shadow-inner border-2 border-transparent focus:border-indigo-500/20">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span x-text="labels[selected]"></span>
                            </div>
                            <svg class="w-5 h-5 text-indigo-400 transition-transform duration-300"
                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <input type="hidden" name="bulan" :value="selected">

                        <div x-show="open" @click.outside="open = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-[1.5rem] shadow-2xl overflow-y-auto max-h-60 p-2">
                            <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <button type="button" @click="selected = '<?php echo e($m); ?>'; open = false"
                                    class="w-full px-4 py-3 text-left hover:bg-indigo-50 rounded-xl transition-all group flex items-center justify-between">
                                    <span class="font-bold text-gray-600 group-hover:text-indigo-600">
                                        <?php echo e(DateTime::createFromFormat('!m', $m)->format('F')); ?>

                                    </span>
                                    <div x-show="selected == '<?php echo e($m); ?>'"
                                        class="w-2 h-2 rounded-full bg-indigo-500"></div>
                                </button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                <div class="space-y-2" x-data="{
                    open: false,
                    selected: '<?php echo e($tahun); ?>'
                }">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-2">Pilih Tahun</label>
                    <div class="relative">
                        <button type="button" @click="open = !open"
                            class="w-full px-5 py-4 bg-gray-50 rounded-2xl flex items-center justify-between transition-all font-bold text-gray-700 shadow-inner border-2 border-transparent focus:border-indigo-500/20">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span x-text="selected"></span>
                            </div>
                            <svg class="w-5 h-5 text-indigo-400 transition-transform duration-300"
                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <input type="hidden" name="tahun" :value="selected">

                        <div x-show="open" @click.outside="open = false"
                            x-transition:enter="transition ease-out duration-100"
                            class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-[1.5rem] shadow-2xl p-2">
                            <?php $__currentLoopData = range(date('Y'), date('Y') - 5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <button type="button" @click="selected = '<?php echo e($y); ?>'; open = false"
                                    class="w-full px-4 py-3 text-left hover:bg-indigo-50 rounded-xl transition-all group flex items-center justify-between">
                                    <span
                                        class="font-bold text-gray-600 group-hover:text-indigo-600"><?php echo e($y); ?></span>
                                    <div x-show="selected == '<?php echo e($y); ?>'"
                                        class="w-2 h-2 rounded-full bg-indigo-500"></div>
                                </button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-[1.25rem] font-black text-sm transition-all shadow-xl shadow-indigo-100 flex items-center justify-center gap-3 uppercase tracking-widest transform hover:-translate-y-1 active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                        </path>
                    </svg>
                    Filter Data
                </button>
            </form>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th
                                class="px-8 py-6 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                Pegawai</th>
                            <th
                                class="px-8 py-6 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                Info Jabatan</th>
                            <th
                                class="px-8 py-6 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                Total Tugas</th>
                            <th
                                class="px-8 py-6 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                Beban Kerja</th>
                            <th
                                class="px-8 py-6 text-right text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        <?php $__empty_1 = true; $__currentLoopData = $pegawai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-indigo-50/30 transition-all duration-300 group">
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-black text-sm shadow-lg shadow-indigo-100 transform group-hover:scale-110 transition-transform">
                                            <?php echo e(substr($p->name, 0, 2)); ?>

                                        </div>
                                        <div>
                                            <div
                                                class="text-sm font-black text-gray-900 group-hover:text-indigo-600 transition-colors">
                                                <?php echo e($p->name); ?></div>
                                            <div class="text-[11px] font-bold text-gray-400 tracking-wider">NIP:
                                                <?php echo e($p->nip); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <span
                                        class="px-4 py-1.5 bg-gray-100 text-gray-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-gray-200/50">
                                        <?php echo e($p->jabatan); ?>

                                    </span>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap text-center">
                                    <div
                                        class="inline-flex items-center justify-center min-w-[3rem] px-3 py-1 bg-white border-2 border-gray-50 rounded-2xl shadow-sm">
                                        <span class="text-sm font-black text-gray-700"><?php echo e($p->total_tugas); ?></span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap text-center">
                                    <div class="flex flex-col items-center">
                                        <span class="text-sm font-black text-indigo-600"><?php echo e($p->total_jam); ?> <span
                                                class="text-[10px] text-gray-400 font-bold uppercase ml-0.5">Jam</span></span>
                                        <div class="w-32 h-2 bg-gray-100 rounded-full mt-2 overflow-hidden p-[1px]">
                                            <div class="h-full bg-gradient-to-r from-indigo-500 to-indigo-400 rounded-full transition-all duration-1000 shadow-[0_0_8px_rgba(79,70,229,0.4)]"
                                                style="width: <?php echo e(min(($p->total_jam / 160) * 100, 100)); ?>%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap text-right">
                                    <a href="<?php echo e(route('admin.laporan.detail-pegawai', ['pegawai' => $p->id, 'bulan' => $bulan, 'tahun' => $tahun])); ?>"
                                        class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-200 text-indigo-600 font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all duration-300 shadow-sm">
                                        Detail
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\penugasan-pegawai\resources\views/admin/laporan/rekap-penugasan.blade.php ENDPATH**/ ?>