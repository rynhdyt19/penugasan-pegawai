

<?php $__env->startSection('title', 'Data Pegawai'); ?>

<?php $__env->startSection('content'); ?>
    <div class="px-4 sm:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Data Pegawai</h2>
            <a href="<?php echo e(route('admin.pegawai.create')); ?>"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Pegawai
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 border-collapse">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-6 py-4 border-b border-r border-gray-200 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            NIP</th>
                        <th
                            class="px-6 py-4 border-b border-r border-gray-200 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            Nama Pegawai</th>
                        <th
                            class="px-6 py-4 border-b border-r border-gray-200 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            Jabatan</th>
                        <th
                            class="px-6 py-4 border-b border-r border-gray-200 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            Seksi</th>
                        <th
                            class="px-6 py-4 border-b border-r border-gray-200 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            Kontak</th>
                        <th
                            class="px-6 py-4 border-b border-r border-gray-200 text-left text-xs font-bold text-gray-600 uppercase tracking-wider text-center">
                            Total Tugas</th>
                        <th class="px-6 py-4 border-b text-center border-gray-200 text-xs font-bold text-gray-600 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $pegawai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td
                                class="px-6 py-4 border-r border-gray-200 whitespace-nowrap text-sm font-medium text-gray-700">
                                <?php echo e($p->nip); ?>

                            </td>
                            <td class="px-6 py-4 border-r border-gray-200 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="h-9 w-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs mr-3 border border-indigo-200">
                                        <?php echo e(substr($p->name, 0, 2)); ?>

                                    </div>
                                    <div class="text-sm font-semibold text-gray-900"><?php echo e($p->name); ?></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 border-r border-gray-200 whitespace-nowrap text-sm text-gray-600">
                                <?php echo e($p->jabatan); ?>

                            </td>
                            <td class="px-6 py-4 border-r border-gray-200 whitespace-nowrap text-sm text-gray-600">
                                <?php echo e($p->seksi); ?>

                            </td>
                            <td class="px-6 py-4 border-r border-gray-200 whitespace-nowrap text-sm text-gray-600">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    <?php echo e($p->kontak); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 border-r border-gray-200 whitespace-nowrap text-center">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">
                                    <?php echo e($p->penugasan_count); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center space-x-2">
                                    <a href="<?php echo e(route('admin.pegawai.show', $p)); ?>"
                                        class="p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition-all duration-200"
                                        title="Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </a>

                                    <a href="<?php echo e(route('admin.pegawai.edit', $p)); ?>"
                                        class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-200"
                                        title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>

                                    <form action="<?php echo e(route('admin.pegawai.destroy', $p)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit"
                                            class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-200"
                                            onclick="return confirm('Yakin hapus pegawai ini?')" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-gray-500 italic bg-gray-50">
                                Belum ada data pegawai yang terdaftar.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <?php echo e($pegawai->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\penugasan-pegawai\resources\views/admin/pegawai/index.blade.php ENDPATH**/ ?>