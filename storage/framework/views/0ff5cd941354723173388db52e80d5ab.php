

<?php $__env->startSection('title', 'Jadwal Tugas'); ?>
<?php $__env->startSection('header_title', 'Jadwal Penugasan Saya'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Jadwal Tugas</h2>
            <p class="text-sm font-medium text-gray-500 mt-1">Daftar agenda penugasan Anda berdasarkan urutan tanggal.</p>
        </div>

        <div class="bg-white rounded-[1.5rem] border border-gray-100 shadow-sm p-5 mb-8">
            <form method="GET" action="<?php echo e(route('pegawai.jadwal')); ?>" class="flex flex-col md:flex-row items-end gap-4">
                <div class="w-full md:w-1/3">
                    <label
                        class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Bulan</label>
                    <select name="bulan"
                        class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-gray-700 focus:ring-2 focus:ring-indigo-500/10 transition-all outline-none">
                        <?php for($i = 1; $i <= 12; $i++): ?>
                            <option value="<?php echo e($i); ?>" <?php echo e($bulan == $i ? 'selected' : ''); ?>>
                                <?php echo e(DateTime::createFromFormat('!m', $i)->format('F')); ?>

                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="w-full md:w-1/3">
                    <label
                        class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Tahun</label>
                    <select name="tahun"
                        class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-gray-700 focus:ring-2 focus:ring-indigo-500/10 transition-all outline-none">
                        <?php for($i = date('Y') - 1; $i <= date('Y') + 2; $i++): ?>
                            <option value="<?php echo e($i); ?>" <?php echo e($tahunSaatIni == $i ? 'selected' : ''); ?>>
                                <?php echo e($i); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <button type="submit"
                    class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl text-xs font-black transition-all shadow-lg shadow-indigo-100 uppercase tracking-widest">
                    Filter
                </button>
            </form>
        </div>

        <div class="space-y-10">
            <?php if($jadwalByDate->count() > 0): ?>
                <?php $__currentLoopData = $jadwalByDate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $tasks): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="relative">
                        <div class="flex items-center gap-3 mb-5">
                            <div
                                class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 shadow-sm border border-indigo-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-gray-900 leading-none capitalize">
                                    <?php echo e(Carbon\Carbon::parse($date)->translatedFormat('l, d F Y')); ?>

                                </h3>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Agenda Hari
                                    Ini</p>
                            </div>
                        </div>

                        <div class="space-y-4 border-l-2 border-indigo-50 ml-5 pl-8">
                            <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $penugasan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $tugas = $penugasan->tugas; ?>
                                <div
                                    class="group bg-white rounded-2xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-all duration-300 relative">
                                    <div
                                        class="absolute -left-[37px] top-1/2 -translate-y-1/2 w-4 h-4 rounded-full bg-white border-4 border-indigo-200">
                                    </div>

                                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-3">
                                                <span
                                                    class="px-2 py-0.5 text-[9px] font-black uppercase tracking-tighter rounded <?php echo e($tugas->prioritas_color ?? 'bg-indigo-100 text-indigo-600'); ?>">
                                                    <?php echo e($tugas->prioritas); ?>

                                                </span>
                                                <span
                                                    class="px-2 py-0.5 text-[9px] font-black uppercase tracking-tighter rounded bg-gray-100 text-gray-500">
                                                    ID: #<?php echo e($tugas->id); ?>

                                                </span>
                                            </div>

                                            <h4
                                                class="text-base font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">
                                                <?php echo e($tugas->nama_tugas); ?>

                                            </h4>

                                            <div
                                                class="mt-3 flex flex-wrap gap-x-6 gap-y-2 text-[11px] font-bold text-gray-500">
                                                <span class="flex items-center gap-1.5">
                                                    📍 <?php echo e($tugas->lokasi); ?>

                                                </span>
                                                <span class="flex items-center gap-1.5">
                                                    ⏱️ <?php echo e($tugas->durasi); ?> Jam
                                                </span>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-6 shrink-0 border-t lg:border-t-0 pt-4 lg:pt-0">
                                            <div class="text-right hidden lg:block">
                                                <p class="text-[9px] font-black text-gray-300 uppercase leading-none mb-1">
                                                    Status</p>
                                                <p
                                                    class="text-[10px] font-extrabold text-indigo-600 uppercase tracking-wider">
                                                    <?php echo e($tugas->status); ?></p>
                                            </div>
                                            <a href="<?php echo e(route('pegawai.tugas.detail', $tugas)); ?>"
                                                class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.2em] px-4 py-2 border-2 border-indigo-100 rounded-xl hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all duration-300">
                                                Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="bg-white rounded-[2rem] border-2 border-dashed border-gray-100 p-16 text-center">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Tidak ada penugasan ditemukan</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\penugasan-pegawai\resources\views/pegawai/jadwal-tugas.blade.php ENDPATH**/ ?>