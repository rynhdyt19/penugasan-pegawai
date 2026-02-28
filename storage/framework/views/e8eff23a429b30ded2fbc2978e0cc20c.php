

<?php $__env->startSection('title', 'Edit Tugas'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-3xl mx-auto animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Tugas</h2>
                <p class="text-gray-500 mt-1 flex items-center italic">
                    <svg class="w-4 h-4 mr-1 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                        </path>
                    </svg>
                    Mengubah rincian: <span class="ml-1 font-bold text-gray-700">#<?php echo e($tugas->id); ?> -
                        <?php echo e($tugas->nama_tugas); ?></span>
                </p>
            </div>
            <a href="<?php echo e(route('admin.tugas.index')); ?>"
                class="text-sm font-bold text-gray-400 hover:text-indigo-600 transition-colors flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 8 8 0 01-18 0z"></path>
                </svg>
                KEMBALI
            </a>
        </div>

        <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-100/50 border border-gray-100 overflow-hidden">
            <div class="p-8 md:p-10">
                <form action="<?php echo e(route('admin.tugas.update', $tugas)); ?>" method="POST" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Nama Tugas <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama_tugas" value="<?php echo e(old('nama_tugas', $tugas->nama_tugas)); ?>" required
                            class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-gray-900 placeholder-gray-400"
                            placeholder="Contoh: Audit Tahunan">
                        <?php $__errorArgs = ['nama_tugas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-xs font-bold mt-1 ml-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Tanggal
                                Pelaksanaan <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal"
                                value="<?php echo e(old('tanggal', $tugas->tanggal->format('Y-m-d'))); ?>" required
                                class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-gray-900">
                            <?php $__errorArgs = ['tanggal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs font-bold mt-1 ml-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Estimasi
                                Durasi (Jam) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="number" name="durasi" value="<?php echo e(old('durasi', $tugas->durasi)); ?>" required
                                    min="1"
                                    class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-gray-900"
                                    placeholder="0">
                                <span
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] font-black uppercase">JAM</span>
                            </div>
                            <?php $__errorArgs = ['durasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs font-bold mt-1 ml-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Lokasi Kerja
                            <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </span>
                            <input type="text" name="lokasi" value="<?php echo e(old('lokasi', $tugas->lokasi)); ?>" required
                                class="w-full pl-11 pr-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-gray-900"
                                placeholder="Contoh: Ruang Rapat Lt. 2">
                        </div>
                        <?php $__errorArgs = ['lokasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-xs font-bold mt-1 ml-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1" x-data="{
                            open: false,
                            selected: '<?php echo e(old('prioritas', $tugas->prioritas)); ?>',
                            labels: { 'rendah': 'Rendah', 'sedang': 'Sedang', 'tinggi': 'Tinggi', 'urgent': 'Urgent' },
                            colors: { 'rendah': 'bg-emerald-400', 'sedang': 'bg-amber-400', 'tinggi': 'bg-orange-400', 'urgent': 'bg-rose-500' }
                        }">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Tingkat
                                Prioritas</label>
                            <div class="relative">
                                <button type="button" @click="open = !open"
                                    class="w-full px-4 py-3 bg-gray-50 border-2 border-transparent focus:border-indigo-400 rounded-2xl flex items-center justify-between transition-all font-bold text-gray-700 shadow-sm">
                                    <div class="flex items-center gap-3">
                                        <span :class="colors[selected]" class="w-3 h-3 rounded-full shadow-sm"></span>
                                        <span x-text="labels[selected]"></span>
                                    </div>
                                    <svg class="w-5 h-5 text-indigo-400 transition-transform"
                                        :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <input type="hidden" name="prioritas" :value="selected">
                                <div x-show="open" @click.outside="open = false" x-transition
                                    class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-[1.5rem] shadow-xl overflow-hidden">
                                    <?php $__currentLoopData = ['rendah' => 'bg-emerald-400', 'sedang' => 'bg-amber-400', 'tinggi' => 'bg-orange-400', 'urgent' => 'bg-rose-500']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $dot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <button type="button" @click="selected = '<?php echo e($val); ?>'; open = false"
                                            class="w-full px-4 py-3 text-left hover:bg-indigo-50 transition-all flex items-center gap-3 group">
                                            <span class="w-3 h-3 rounded-full <?php echo e($dot); ?>"></span>
                                            <span
                                                class="font-bold text-gray-600 group-hover:text-indigo-600 capitalize"><?php echo e($val); ?></span>
                                        </button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-1" x-data="{
                            open: false,
                            selected: '<?php echo e(old('status', $tugas->status)); ?>',
                            labels: { 'pending': 'Pending', 'assigned': 'Assigned', 'selesai': 'Selesai', 'dibatalkan': 'Dibatalkan' },
                            colors: { 'pending': 'bg-gray-400', 'assigned': 'bg-indigo-400', 'selesai': 'bg-emerald-400', 'dibatalkan': 'bg-rose-400' }
                        }">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Status
                                Progres</label>
                            <div class="relative">
                                <button type="button" @click="open = !open"
                                    class="w-full px-4 py-3 bg-gray-50 border-2 border-transparent focus:border-indigo-400 rounded-2xl flex items-center justify-between transition-all font-bold text-gray-700 shadow-sm">
                                    <div class="flex items-center gap-3">
                                        <span :class="colors[selected]" class="w-3 h-3 rounded-full shadow-sm"></span>
                                        <span x-text="labels[selected]"></span>
                                    </div>
                                    <svg class="w-5 h-5 text-indigo-400 transition-transform"
                                        :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <input type="hidden" name="status" :value="selected">
                                <div x-show="open" @click.outside="open = false" x-transition
                                    class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-[1.5rem] shadow-xl overflow-hidden">
                                    <?php $__currentLoopData = ['pending' => 'bg-gray-400', 'assigned' => 'bg-indigo-400', 'selesai' => 'bg-emerald-400', 'dibatalkan' => 'bg-rose-400']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $dot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <button type="button" @click="selected = '<?php echo e($val); ?>'; open = false"
                                            class="w-full px-4 py-3 text-left hover:bg-indigo-50 transition-all flex items-center gap-3 group">
                                            <span class="w-3 h-3 rounded-full <?php echo e($dot); ?>"></span>
                                            <span
                                                class="font-bold text-gray-600 group-hover:text-indigo-600 capitalize"><?php echo e($val); ?></span>
                                        </button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Catatan
                            Tambahan</label>
                        <textarea name="keterangan" rows="4"
                            class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-gray-900 placeholder-gray-400"
                            placeholder="Tambahkan detail instruksi atau catatan di sini..."><?php echo e(old('keterangan', $tugas->keterangan)); ?></textarea>
                        <?php $__errorArgs = ['keterangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-xs font-bold mt-1 ml-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="pt-6 flex flex-col sm:flex-row gap-3">
                        <button type="submit"
                            class="flex-1 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-sm transition-all shadow-lg shadow-indigo-200 transform hover:-translate-y-1 uppercase tracking-widest">
                            SIMPAN PERUBAHAN
                        </button>
                        <a href="<?php echo e(route('admin.tugas.index')); ?>"
                            class="flex-1 py-4 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-2xl font-black text-sm transition-all text-center uppercase tracking-widest flex items-center justify-center">
                            BATALKAN
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\penugasan-pegawai\resources\views/admin/tugas/edit.blade.php ENDPATH**/ ?>