

<?php $__env->startSection('title', 'Detail Tugas'); ?>
<?php $__env->startSection('header_title', 'Informasi Penugasan'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-5xl mx-auto">
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <a href="<?php echo e(route('pegawai.jadwal')); ?>"
                    class="group inline-flex items-center text-xs font-black text-indigo-600 uppercase tracking-widest mb-3">
                    <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Jadwal
                </a>
                <h2 class="text-3xl font-black text-gray-900 tracking-tight">Detail Tugas</h2>
                <p class="text-sm font-medium text-gray-500 mt-1">ID Penugasan: <span
                        class="text-indigo-600 font-bold">#<?php echo e($tugas->id); ?></span></p>
            </div>

            <div class="flex items-center gap-3">
                <span
                    class="px-4 py-2 text-[10px] font-black uppercase tracking-[0.2em] rounded-xl <?php echo e($tugas->prioritas_color ?? 'bg-indigo-50 text-indigo-600'); ?>">
                    <?php echo e($tugas->prioritas); ?>

                </span>
                <span
                    class="px-4 py-2 text-[10px] font-black uppercase tracking-[0.2em] rounded-xl <?php echo e($tugas->status_color ?? 'bg-gray-100 text-gray-600'); ?>">
                    <?php echo e($tugas->status); ?>

                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <div
                    class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm p-8 md:p-10 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50/50 rounded-full -mr-16 -mt-16"></div>

                    <div class="relative">
                        <h3 class="text-2xl font-black text-gray-900 leading-tight mb-8">
                            <?php echo e($tugas->nama_tugas); ?>

                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                            <div class="space-y-1">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal
                                    Pelaksanaan</label>
                                <div class="flex items-center gap-3">
                                    <p class="text-lg font-bold text-gray-900">
                                        <?php echo e($tugas->tanggal->translatedFormat('d F Y')); ?></p>
                                    <?php if($tugas->is_hari_ini): ?>
                                        <span
                                            class="animate-pulse bg-red-100 text-red-600 text-[9px] font-black px-2 py-0.5 rounded-md uppercase">Hari
                                            Ini</span>
                                    <?php endif; ?>
                                </div>
                                <p class="text-xs font-bold text-indigo-500">
                                    <?php echo e($tugas->sisa_hari > 0 ? $tugas->sisa_hari . ' hari lagi' : abs($tugas->sisa_hari) . ' hari yang lalu'); ?>

                                </p>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Durasi
                                    Kerja</label>
                                <p class="text-lg font-bold text-gray-900"><?php echo e($tugas->durasi); ?> Jam</p>
                                <p class="text-xs font-medium text-gray-400 italic">Estimasi waktu penyelesaian</p>
                            </div>

                            <div class="md:col-span-2 space-y-1">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Lokasi
                                    Penugasan</label>
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center text-gray-400">
                                        📍
                                    </div>
                                    <p class="text-lg font-bold text-gray-900"><?php echo e($tugas->lokasi); ?></p>
                                </div>
                            </div>
                        </div>

                        <?php if($tugas->keterangan): ?>
                            <div class="pt-8 border-t border-gray-50">
                                <label
                                    class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Keterangan
                                    Tambahan</label>
                                <div class="bg-gray-50 rounded-2xl p-5">
                                    <p class="text-sm leading-relaxed text-gray-600 font-medium italic">
                                        "<?php echo e($tugas->keterangan); ?>"</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if($penugasan->catatan): ?>
                    <div class="bg-amber-50/50 border border-amber-100 rounded-[2rem] p-8">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="text-xl">📝</span>
                            <h3 class="text-sm font-black text-amber-900 uppercase tracking-widest">Catatan Admin</h3>
                        </div>
                        <p class="text-sm font-bold text-amber-800/80 leading-relaxed">
                            <?php echo e($penugasan->catatan); ?>

                        </p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-6">
                    <h3 class="text-xs font-black text-gray-900 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                        <span class="w-2 h-2 bg-indigo-600 rounded-full"></span>
                        Timeline
                    </h3>

                    <div class="space-y-8 relative">
                        <div class="absolute left-4 top-2 bottom-2 w-0.5 bg-gray-50"></div>

                        <div class="relative flex items-start gap-4 pl-1">
                            <div
                                class="relative z-10 w-6 h-6 bg-white border-2 border-indigo-600 rounded-full flex items-center justify-center">
                                <div class="w-2 h-2 bg-indigo-600 rounded-full"></div>
                            </div>
                            <div>
                                <p class="text-[11px] font-black text-gray-900 uppercase">Ditugaskan</p>
                                <p class="text-[10px] font-bold text-gray-400 mt-1 leading-none">
                                    <?php echo e($penugasan->assigned_at->format('d M Y, H:i')); ?>

                                </p>
                            </div>
                        </div>

                        <?php if($penugasan->completed_at): ?>
                            <div class="relative flex items-start gap-4 pl-1">
                                <div
                                    class="relative z-10 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[11px] font-black text-gray-900 uppercase">Selesai</p>
                                    <p class="text-[10px] font-bold text-gray-400 mt-1 leading-none">
                                        <?php echo e($penugasan->completed_at->format('d M Y, H:i')); ?>

                                    </p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div
                    class="bg-indigo-600 rounded-[2rem] p-6 text-white shadow-xl shadow-indigo-100 relative overflow-hidden group">
                    <div
                        class="absolute -right-4 -bottom-4 opacity-10 transform group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" />
                        </svg>
                    </div>
                    <h4 class="text-xs font-black uppercase tracking-widest mb-4 flex items-center gap-2">
                        <span>💡</span> Tips Kerja
                    </h4>
                    <ul class="space-y-3 relative z-10">
                        <li class="flex items-start gap-2 text-[11px] font-bold leading-relaxed text-indigo-100">
                            <span class="mt-1">•</span> Datang tepat waktu
                        </li>
                        <li class="flex items-start gap-2 text-[11px] font-bold leading-relaxed text-indigo-100">
                            <span class="mt-1">•</span> Siapkan perlengkapan
                        </li>
                        <li class="flex items-start gap-2 text-[11px] font-bold leading-relaxed text-indigo-100">
                            <span class="mt-1">•</span> Hubungi admin jika ada kendala
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\penugasan-pegawai\resources\views/pegawai/detail-tugas.blade.php ENDPATH**/ ?>