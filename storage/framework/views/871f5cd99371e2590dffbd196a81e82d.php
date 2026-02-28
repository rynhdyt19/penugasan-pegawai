

<?php $__env->startSection('title', 'Statistik Beban Kerja'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 animate-in fade-in duration-700">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Statistik Beban Kerja</h2>
                <p class="text-gray-500 mt-1">Analisis distribusi tugas dan efisiensi pegawai.</p>
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
            <form method="GET" action="<?php echo e(route('admin.laporan.statistik')); ?>"
                class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">

                <div class="space-y-2" x-data="{
                    open: false,
                    selected: '<?php echo e($bulan); ?>',
                    labels: {
                        <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        '<?php echo e($m); ?>': '<?php echo e(DateTime::createFromFormat('!m', $m)->format('F')); ?>'<?php echo e(!$loop->last ? ',' : ''); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    }
                }">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-2">Periode
                        Bulan</label>
                    <div class="relative">
                        <button type="button" @click="open = !open"
                            class="w-full px-5 py-4 bg-gray-50 rounded-2xl flex items-center justify-between transition-all font-bold text-gray-700 shadow-inner border-2 border-transparent focus:border-indigo-500/20">
                            <span x-text="labels[selected]"></span>
                            <svg class="w-5 h-5 text-indigo-400 transition-transform" :class="open ? 'rotate-180' : ''"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <input type="hidden" name="bulan" :value="selected">
                        <div x-show="open" @click.outside="open = false" x-transition
                            class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-[1.5rem] shadow-2xl overflow-y-auto max-h-60 p-2">
                            <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <button type="button" @click="selected = '<?php echo e($m); ?>'; open = false"
                                    class="w-full px-4 py-3 text-left hover:bg-indigo-50 rounded-xl transition-all group flex items-center justify-between">
                                    <span
                                        class="font-bold text-gray-600 group-hover:text-indigo-600"><?php echo e(DateTime::createFromFormat('!m', $m)->format('F')); ?></span>
                                    <div x-show="selected == '<?php echo e($m); ?>'"
                                        class="w-2 h-2 rounded-full bg-indigo-500"></div>
                                </button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                <div class="space-y-2" x-data="{ open: false, selected: '<?php echo e($tahun); ?>' }">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-2">Pilih Tahun</label>
                    <div class="relative">
                        <button type="button" @click="open = !open"
                            class="w-full px-5 py-4 bg-gray-50 rounded-2xl flex items-center justify-between transition-all font-bold text-gray-700 shadow-inner border-2 border-transparent focus:border-indigo-500/20">
                            <span x-text="selected"></span>
                            <svg class="w-5 h-5 text-indigo-400 transition-transform" :class="open ? 'rotate-180' : ''"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <input type="hidden" name="tahun" :value="selected">
                        <div x-show="open" @click.outside="open = false" x-transition
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
                    class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-xs transition-all shadow-lg shadow-indigo-100 uppercase tracking-[0.2em]">
                    Tampilkan Analisis
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-xl shadow-gray-200/40">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Total Tugas</p>
                <div class="flex items-end gap-2">
                    <span class="text-3xl font-black text-indigo-600"><?php echo e($totalTugas); ?></span>
                    <span class="text-xs font-bold text-gray-400 mb-1">Item</span>
                </div>
            </div>
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-xl shadow-gray-200/40">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Rata-rata Beban</p>
                <div class="flex items-end gap-2">
                    <span class="text-3xl font-black text-emerald-500"><?php echo e(round($rataRataTugas, 1)); ?></span>
                    <span class="text-xs font-bold text-gray-400 mb-1">Tugas/Org</span>
                </div>
            </div>
            <div
                class="bg-white rounded-3xl p-6 border border-gray-100 shadow-xl shadow-gray-200/40 border-l-4 border-l-purple-500">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Beban Tertinggi</p>
                <p class="text-sm font-black text-gray-900 truncate"><?php echo e($pegawaiTertinggi->name ?? '-'); ?></p>
                <p class="text-[11px] font-bold text-purple-600 mt-1"><?php echo e($pegawaiTertinggi->total_tugas ?? 0); ?> Tugas
                    Terdaftar</p>
            </div>
            <div
                class="bg-white rounded-3xl p-6 border border-gray-100 shadow-xl shadow-gray-200/40 border-l-4 border-l-amber-500">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Beban Terendah</p>
                <p class="text-sm font-black text-gray-900 truncate"><?php echo e($pegawaiTerendah->name ?? '-'); ?></p>
                <p class="text-[11px] font-bold text-amber-600 mt-1"><?php echo e($pegawaiTerendah->total_tugas ?? 0); ?> Tugas
                    Terdaftar</p>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/30">
                <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest">Detail Beban Kerja per Pegawai</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead>
                        <tr class="bg-white">
                            <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                Identitas Pegawai</th>
                            <th
                                class="px-8 py-5 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                Jabatan</th>
                            <th
                                class="px-8 py-5 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                Kapasitas</th>
                            <th
                                class="px-8 py-5 text-right text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                Persentase Beban</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        <?php $__empty_1 = true; $__currentLoopData = $pegawai->sortByDesc('total_tugas'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $percentage = $rataRataTugas > 0 ? ($p->total_tugas / $rataRataTugas) * 100 : 0;
                                $config = match (true) {
                                    $percentage > 120 => [
                                        'bar' => 'bg-red-500',
                                        'text' => 'text-red-600',
                                        'bg' => 'bg-red-50',
                                    ],
                                    $percentage > 100 => [
                                        'bar' => 'bg-amber-500',
                                        'text' => 'text-amber-600',
                                        'bg' => 'bg-amber-50',
                                    ],
                                    default => [
                                        'bar' => 'bg-emerald-500',
                                        'text' => 'text-emerald-600',
                                        'bg' => 'bg-emerald-50',
                                    ],
                                };
                            ?>
                            <tr class="hover:bg-indigo-50/20 transition-colors">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-[10px] font-black text-gray-500 italic border border-gray-200">
                                            NIP
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-black text-gray-900"><?php echo e($p->name); ?></span>
                                            <span
                                                class="text-[10px] font-bold text-gray-400 tracking-wider"><?php echo e($p->nip); ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span
                                        class="px-3 py-1 bg-gray-100 rounded-lg text-[10px] font-black text-gray-500 uppercase tracking-widest"><?php echo e($p->jabatan); ?></span>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <div class="flex flex-col items-center">
                                        <span class="text-sm font-black text-gray-700"><?php echo e($p->total_tugas); ?> <span
                                                class="text-[10px] text-gray-400 font-bold uppercase ml-1">Tugas</span></span>
                                        <span class="text-[10px] font-bold text-gray-400 italic"><?php echo e($p->total_jam); ?>

                                            Jam</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center justify-end gap-4">
                                        <div class="flex flex-col items-end flex-1 max-w-[150px]">
                                            <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                                <div class="<?php echo e($config['bar']); ?> h-full transition-all duration-1000"
                                                    style="width: <?php echo e(min($percentage, 100)); ?>%"></div>
                                            </div>
                                        </div>
                                        <div class="min-w-[60px] text-right">
                                            <span
                                                class="px-2 py-1 <?php echo e($config['bg']); ?> <?php echo e($config['text']); ?> rounded-lg text-xs font-black">
                                                <?php echo e(number_format($percentage, 0)); ?>%
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                <p class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider">0-100%: Beban Normal</p>
            </div>
            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-100 flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></div>
                <p class="text-[11px] font-bold text-amber-800 uppercase tracking-wider">100-120%: Beban Meningkat</p>
            </div>
            <div class="p-4 rounded-2xl bg-red-50 border border-red-100 flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></div>
                <p class="text-[11px] font-bold text-red-800 uppercase tracking-wider">>120%: Overload (Redistribusi)</p>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\penugasan-pegawai\resources\views/admin/laporan/statistik-beban.blade.php ENDPATH**/ ?>