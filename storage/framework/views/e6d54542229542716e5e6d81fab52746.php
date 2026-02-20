

<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-[1600px] mx-auto p-6 lg:p-8">
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Dashboard Admin</h2>
                <p class="text-gray-500 mt-1 font-medium">Pantau produktivitas dan distribusi tugas tim Anda.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="<?php echo e(route('admin.laporan.index')); ?>"
                    class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-gray-700 bg-white border-2 border-gray-100 rounded-2xl hover:bg-gray-50 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Export
                </a>
                <a href="<?php echo e(route('admin.tugas.create')); ?>"
                    class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-indigo-600 rounded-2xl hover:bg-indigo-700 hover:-translate-y-0.5 transition-all shadow-lg shadow-indigo-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Tugas
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
            <div class="xl:col-span-3 space-y-8">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform">
                            <svg class="w-16 h-16 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V5h2v4z"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Tugas Pending</p>
                        <h3 class="text-4xl font-black text-gray-900 mt-2"><?php echo e($tugasPending); ?></h3>
                        <div
                            class="mt-4 flex items-center text-xs font-bold text-blue-600 bg-blue-50 w-fit px-2 py-1 rounded-lg italic">
                            Menunggu Eksekusi
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform">
                            <svg class="w-16 h-16 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Minggu Ini</p>
                        <h3 class="text-4xl font-black text-gray-900 mt-2"><?php echo e($tugasMingguIni); ?></h3>
                        <div
                            class="mt-4 flex items-center text-xs font-bold text-green-600 bg-green-50 w-fit px-2 py-1 rounded-lg italic">
                            Tugas Terjadwal
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform">
                            <svg class="w-16 h-16 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z">
                                </path>
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Rata-rata Beban</p>
                        <h3 class="text-4xl font-black text-gray-900 mt-2">
                            <?php echo e($totalPegawai > 0 ? round($totalTugas / $totalPegawai, 0) : 0); ?>%
                        </h3>
                        <div
                            class="mt-4 flex items-center text-xs font-bold text-purple-600 bg-purple-50 w-fit px-2 py-1 rounded-lg italic">
                            Kapasitas Tim
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-xl shadow-gray-200/50 overflow-hidden">
                    <div class="p-8">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Data Pegawai Terbaru</h3>
                                <p class="text-sm text-gray-400 font-medium">Kelola profil dan jabatan anggota tim.</p>
                            </div>
                            <a href="<?php echo e(route('admin.pegawai.create')); ?>"
                                class="text-sm font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1 transition-all">
                                <span class="bg-indigo-50 p-2 rounded-xl text-indigo-600 group-hover:bg-indigo-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </span>
                                Tambah Pegawai
                            </a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-separate border-spacing-y-3">
                                <thead>
                                    <tr class="text-gray-400 text-xs uppercase tracking-widest font-bold">
                                        <th class="px-4 py-2">User</th>
                                        <th class="px-4 py-2 hidden md:table-cell">NIP/Jabatan</th>
                                        <th class="px-4 py-2 hidden lg:table-cell">Seksi</th>
                                        <th class="px-4 py-2 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = \App\Models\User::where('role', 'pegawai')->latest()->take(5)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pegawai): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="group hover:bg-gray-50/80 transition-all">
                                            <td
                                                class="px-4 py-4 bg-gray-50/50 rounded-l-2xl group-hover:bg-indigo-50/30 transition-colors">
                                                <div class="flex items-center gap-3">
                                                    <div class="relative">
                                                        <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($pegawai->name)); ?>&background=4F46E5&color=fff&size=40"
                                                            class="w-10 h-10 rounded-xl shadow-sm">
                                                        <span
                                                            class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <p class="text-sm font-bold text-gray-900 truncate">
                                                            <?php echo e($pegawai->name); ?></p>
                                                        <p class="text-xs text-gray-400 truncate">
                                                            <?php echo e($pegawai->email ?? 'no-email@mail.com'); ?></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td
                                                class="px-4 py-4 bg-gray-50/50 group-hover:bg-indigo-50/30 transition-colors hidden md:table-cell">
                                                <p class="text-sm font-bold text-gray-700"><?php echo e($pegawai->nip); ?></p>
                                                <p class="text-xs text-indigo-500 font-semibold"><?php echo e($pegawai->jabatan); ?>

                                                </p>
                                            </td>
                                            <td
                                                class="px-4 py-4 bg-gray-50/50 group-hover:bg-indigo-50/30 transition-colors hidden lg:table-cell italic text-sm text-gray-500 font-medium">
                                                <?php echo e($pegawai->seksi); ?>

                                            </td>
                                            <td
                                                class="px-4 py-4 bg-gray-50/50 rounded-r-2xl group-hover:bg-indigo-50/30 transition-colors text-right">
                                                <a href="<?php echo e(route('admin.pegawai.edit', $pegawai)); ?>"
                                                    class="inline-flex p-2 text-gray-400 hover:text-indigo-600 hover:bg-white rounded-xl transition-all">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-tighter italic">Total:
                                <?php echo e($totalPegawai); ?> Pegawai</p>
                            <a href="<?php echo e(route('admin.pegawai.index')); ?>"
                                class="text-sm font-bold text-indigo-600 hover:underline">Lihat Semua →</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div
                    class="bg-indigo-600 rounded-[2rem] p-8 text-white shadow-xl shadow-indigo-200 relative overflow-hidden group">
                    <div
                        class="absolute -right-10 -bottom-10 opacity-20 group-hover:rotate-12 transition-transform duration-500">
                        <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
                        </svg>
                    </div>

                    <h3 class="text-xl font-black mb-1">Smart Scheduling</h3>
                    <p class="text-indigo-100 text-sm font-medium mb-6">Round Robin Algortihm v1.0</p>

                    <?php $nextQueue = \App\Models\RoundRobinQueue::getNextAvailable(); ?>
                    <div
                        class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 mb-6 transition-all hover:bg-white/20">
                        <p class="text-xs font-bold uppercase tracking-widest text-indigo-200 mb-3">Antrian Berikutnya:</p>
                        <?php if($nextQueue && $nextQueue->user): ?>
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($nextQueue->user->name)); ?>&background=fff&color=4F46E5&size=32"
                                    class="w-8 h-8 rounded-lg">
                                <div class="min-w-0">
                                    <p class="text-sm font-bold truncate"><?php echo e($nextQueue->user->name); ?></p>
                                    <p class="text-[10px] text-indigo-200 font-medium uppercase">
                                        <?php echo e($nextQueue->user->seksi); ?></p>
                                </div>
                            </div>
                        <?php else: ?>
                            <p class="text-sm italic opacity-60 font-medium">Belum ada antrian...</p>
                        <?php endif; ?>
                    </div>

                    <button onclick="window.location.href='<?php echo e(route('admin.tugas.create')); ?>'"
                        class="w-full py-3 bg-white text-indigo-600 rounded-xl font-black text-sm hover:bg-gray-50 transition-all shadow-lg active:scale-95">
                        Jalankan Scheduler
                    </button>
                </div>

                <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm">
                    <h4 class="text-lg font-bold text-gray-900 mb-6">Tugas Terbaru</h4>
                    <div class="space-y-5">
                        <?php $__empty_1 = true; $__currentLoopData = \App\Models\Tugas::latest()->take(3)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tugas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div
                                class="relative pl-6 border-l-2 border-gray-100 hover:border-indigo-500 transition-colors group">
                                <div
                                    class="absolute -left-[5px] top-0 w-2 h-2 rounded-full bg-gray-200 group-hover:bg-indigo-500 transition-colors">
                                </div>
                                <p class="text-xs font-bold text-gray-400 mb-1 uppercase tracking-tighter italic">
                                    <?php echo e($tugas->tanggal->format('d M, Y')); ?></p>
                                <a href="<?php echo e(route('admin.tugas.show', $tugas)); ?>"
                                    class="text-sm font-bold text-gray-800 hover:text-indigo-600 block leading-tight"><?php echo e($tugas->nama_tugas); ?></a>
                                <div class="mt-2 flex items-center gap-2">
                                    <span
                                        class="px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest <?php echo e($tugas->prioritas_color); ?>">
                                        <?php echo e($tugas->prioritas); ?>

                                    </span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-center text-sm text-gray-400 py-4">Tidak ada aktivitas.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="space-y-3">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-2">Quick Reports</p>
                    <a href="<?php echo e(route('admin.laporan.rekap')); ?>"
                        class="flex items-center justify-between p-4 bg-gray-50 hover:bg-indigo-600 hover:text-white rounded-2xl transition-all group">
                        <span class="text-sm font-bold">Rekap Bulanan</span>
                        <svg class="w-5 h-5 opacity-0 group-hover:opacity-100 transition-opacity" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                    <a href="<?php echo e(route('admin.laporan.pdf', ['bulan' => date('n'), 'tahun' => date('Y')])); ?>"
                        class="flex items-center justify-between p-4 bg-gray-50 hover:bg-red-500 hover:text-white rounded-2xl transition-all group font-bold">
                        <span class="text-sm font-bold">Download PDF</span>
                        <svg class="w-5 h-5 opacity-0 group-hover:opacity-100 transition-opacity" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\penugasan-pegawai\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>