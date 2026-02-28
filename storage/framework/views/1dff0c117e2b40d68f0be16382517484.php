

<?php $__env->startSection('title', 'Settings - Admin'); ?>

<?php $__env->startSection('content'); ?>
    <div class="p-4 md:p-10 bg-gray-50/50 min-h-screen">
        <div class="mb-10">
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Pengaturan</h2>
            <p class="text-slate-500 mt-2 text-sm">Kelola identitas digital, keamanan, dan pantau performa kerja Anda</p>
        </div>

        <?php if(session('success')): ?>
            <div
                class="mb-6 bg-emerald-50 border border-emerald-200 p-4 rounded-2xl flex items-center shadow-sm animate-fade-in">
                <svg class="w-5 h-5 text-emerald-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                <p class="text-sm font-medium text-emerald-800"><?php echo e(session('success')); ?></p>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-3">
                <div class="bg-white rounded-[2rem] shadow-sm p-4 border border-gray-100 sticky top-10">
                    <nav class="space-y-2">
                        <button onclick="showTab('profile')" id="tab-profile"
                            class="tab-button w-full flex items-center space-x-4 px-6 py-4 text-sm font-semibold rounded-2xl transition-all duration-200 bg-indigo-50 text-indigo-600 shadow-sm shadow-indigo-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>Profil Saya</span>
                        </button>

                        <button onclick="showTab('password')" id="tab-password"
                            class="tab-button w-full flex items-center space-x-4 px-6 py-4 text-sm font-semibold text-slate-500 hover:bg-gray-50 rounded-2xl transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                            <span>Keamanan</span>
                        </button>

                        <button onclick="showTab('stats')" id="tab-stats"
                            class="tab-button w-full flex items-center space-x-4 px-6 py-4 text-sm font-semibold text-slate-500 hover:bg-gray-50 rounded-2xl transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            <span>Statistik Kinerja</span>
                        </button>
                    </nav>
                </div>
            </div>

            <div class="lg:col-span-9">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden min-h-[600px]">

                    <div id="content-profile" class="tab-content animate-fade-in">
                        <div class="px-10 py-8 border-b border-gray-50 bg-gray-50/30">
                            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-[0.2em]">Informasi Profil</h3>
                        </div>
                        <div class="p-10">
                            <div class="flex flex-col md:flex-row items-center gap-8 mb-12">
                                <div class="relative group">
                                    <div
                                        class="w-32 h-32 rounded-[2.5rem] bg-indigo-600 flex items-center justify-center text-white text-4xl font-bold shadow-xl shadow-indigo-200 overflow-hidden">
                                        <?php if(Auth::user()->photo): ?>
                                            <img src="<?php echo e(asset('storage/' . Auth::user()->photo)); ?>"
                                                class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                                        <?php endif; ?>
                                    </div>
                                    <label for="photo"
                                        class="absolute -bottom-2 -right-2 bg-indigo-500 p-2.5 rounded-2xl text-white cursor-pointer hover:bg-indigo-600 transition shadow-lg border-4 border-white">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </label>
                                </div>

                                <div>
                                    <h4 class="font-bold text-slate-800 text-lg">Avatar Akun</h4>
                                    <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest">PNG, JPG
                                        ATAU GIF (MAKS. 2MB)</p>
                                    <form action="<?php echo e(route('admin.settings.update-photo')); ?>" method="POST"
                                        enctype="multipart/form-data" id="photoForm">
                                        <?php echo csrf_field(); ?>
                                        <input type="file" name="photo" id="photo" class="hidden"
                                            onchange="document.getElementById('photoForm').submit()">
                                        <button type="button" onclick="document.getElementById('photo').click()"
                                            class="mt-4 px-6 py-2 bg-indigo-50 text-indigo-600 text-[10px] font-bold rounded-xl hover:bg-indigo-100 transition uppercase tracking-widest">
                                            Upload Baru
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <form action="<?php echo e(route('admin.settings.update-profile')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10">
                                    <div>
                                        <label
                                            class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">NIP
                                            (Terkunci)</label>
                                        <input type="text" value="<?php echo e(Auth::user()->nip ?? '199001012015011001'); ?>"
                                            class="w-full px-6 py-4 bg-gray-50/50 border-none rounded-2xl text-slate-400 font-medium cursor-not-allowed"
                                            readonly>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Nama
                                            Lengkap</label>
                                        <input type="text" name="name" value="<?php echo e(Auth::user()->name); ?>"
                                            class="w-full px-6 py-4 bg-gray-50/80 border-none focus:ring-2 focus:ring-indigo-500/20 rounded-2xl text-slate-700 font-semibold transition-all">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Email
                                            Instansi</label>
                                        <input type="email" name="email" value="<?php echo e(Auth::user()->email); ?>"
                                            class="w-full px-6 py-4 bg-gray-50/80 border-none focus:ring-2 focus:ring-indigo-500/20 rounded-2xl text-slate-700 font-semibold transition-all">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">No.
                                            WhatsApp</label>
                                        <input type="text" name="kontak" value="<?php echo e(Auth::user()->kontak); ?>"
                                            class="w-full px-6 py-4 bg-gray-50/80 border-none focus:ring-2 focus:ring-indigo-500/20 rounded-2xl text-slate-700 font-semibold transition-all">
                                    </div>
                                </div>
                                <div class="mt-12 flex justify-end">
                                    <button type="submit"
                                        class="px-10 py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition shadow-xl shadow-indigo-200 uppercase tracking-widest text-[10px]">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div id="content-password" class="tab-content hidden animate-fade-in">
                        <div class="px-10 py-8 border-b border-gray-50 bg-gray-50/30">
                            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-[0.2em]">Keamanan Password</h3>
                        </div>
                        <div class="p-10">
                            <form action="<?php echo e(route('admin.settings.update-password')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <div class="max-w-2xl space-y-8">
                                    <div
                                        class="p-6 bg-amber-50 rounded-[2rem] border border-amber-100 flex items-start space-x-4">
                                        <div class="p-2 bg-white rounded-xl shadow-sm">
                                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        </div>
                                        <p class="text-sm text-amber-800 leading-relaxed">Pastikan password baru Anda
                                            minimal 6 karakter dan menggunakan kombinasi simbol untuk keamanan maksimal.</p>
                                    </div>

                                    <div class="space-y-6">
                                        <div>
                                            <label
                                                class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Password
                                                Saat Ini</label>
                                            <input type="password" name="current_password"
                                                class="w-full px-6 py-4 bg-gray-50/80 border-none focus:ring-2 focus:ring-indigo-500/20 rounded-2xl text-slate-700 transition-all"
                                                required>
                                        </div>
                                        <div>
                                            <label
                                                class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Password
                                                Baru</label>
                                            <input type="password" name="password"
                                                class="w-full px-6 py-4 bg-gray-50/80 border-none focus:ring-2 focus:ring-indigo-500/20 rounded-2xl text-slate-700 transition-all"
                                                required>
                                        </div>
                                        <div>
                                            <label
                                                class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Konfirmasi
                                                Password Baru</label>
                                            <input type="password" name="password_confirmation"
                                                class="w-full px-6 py-4 bg-gray-50/80 border-none focus:ring-2 focus:ring-indigo-500/20 rounded-2xl text-slate-700 transition-all"
                                                required>
                                        </div>
                                    </div>

                                    <div class="pt-6 flex justify-end">
                                        <button type="submit"
                                            class="px-10 py-4 bg-slate-900 text-white font-bold rounded-2xl hover:bg-slate-800 transition shadow-xl shadow-slate-200 uppercase tracking-widest text-[10px]">
                                            Perbarui Keamanan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div id="content-stats" class="tab-content hidden animate-fade-in">
                        <div class="px-10 py-8 border-b border-gray-50 bg-gray-50/30">
                            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-[0.2em]">Ringkasan Kinerja</h3>
                        </div>
                        <div class="p-10">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div
                                    class="p-8 bg-indigo-600 rounded-[2.5rem] text-white shadow-xl shadow-indigo-100 relative overflow-hidden group">
                                    <div class="relative z-10">
                                        <p class="text-indigo-100 text-[10px] font-bold uppercase tracking-widest">Total
                                            Pegawai</p>
                                        <p class="text-4xl font-black mt-2"><?php echo e($statistik['total_pegawai'] ?? 0); ?></p>
                                    </div>
                                    <svg class="w-24 h-24 absolute -right-5 -bottom-5 text-white/10 group-hover:scale-110 transition-transform duration-500"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                    </svg>
                                </div>

                                <div
                                    class="p-8 bg-slate-900 rounded-[2.5rem] text-white shadow-xl shadow-slate-200 relative overflow-hidden group">
                                    <div class="relative z-10">
                                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Total Jam
                                            Tugas</p>
                                        <p class="text-4xl font-black mt-2">
                                            <?php echo e(number_format($statistik['total_jam_tugas'] ?? 0, 1)); ?><span
                                                class="text-lg font-medium ml-1 text-slate-500">h</span></p>
                                    </div>
                                    <svg class="w-24 h-24 absolute -right-5 -bottom-5 text-white/5 group-hover:scale-110 transition-transform duration-500"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
                                    </svg>
                                </div>

                                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-6 mt-4">
                                    <div
                                        class="p-6 bg-white border border-gray-100 rounded-3xl shadow-sm flex items-center space-x-4">
                                        <div
                                            class="w-12 h-12 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total
                                                Tugas</p>
                                            <p class="text-xl font-bold text-slate-800">
                                                <?php echo e($statistik['total_tugas'] ?? 0); ?></p>
                                        </div>
                                    </div>
                                    <div
                                        class="p-6 bg-white border border-gray-100 rounded-3xl shadow-sm flex items-center space-x-4">
                                        <div
                                            class="w-12 h-12 bg-yellow-50 text-yellow-500 rounded-2xl flex items-center justify-center">
                                            <div class="w-3 h-3 bg-yellow-400 rounded-full animate-pulse"></div>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tugas
                                                Aktif</p>
                                            <p class="text-xl font-bold text-slate-800">
                                                <?php echo e($statistik['tugas_aktif'] ?? 0); ?></p>
                                        </div>
                                    </div>
                                    <div
                                        class="p-6 bg-white border border-gray-100 rounded-3xl shadow-sm flex items-center space-x-4">
                                        <div
                                            class="w-12 h-12 bg-green-50 text-green-500 rounded-2xl flex items-center justify-center">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                                Selesai</p>
                                            <p class="text-xl font-bold text-slate-800">
                                                <?php echo e($statistik['tugas_selesai'] ?? 0); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Custom focus shadow for rounded inputs */
        input:focus {
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.1);
        }
    </style>

    <script>
        function showTab(tabId) {
            // Sembunyikan semua konten tab
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Tampilkan konten tab yang dipilih
            const activeContent = document.getElementById('content-' + tabId);
            if (activeContent) activeContent.classList.remove('hidden');

            // Reset gaya tombol tab
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('bg-indigo-50', 'text-indigo-600', 'shadow-sm', 'shadow-indigo-100');
                btn.classList.add('text-slate-500', 'hover:bg-gray-50');
            });

            // Aktifkan gaya tombol tab yang dipilih
            const activeBtn = document.getElementById('tab-' + tabId);
            if (activeBtn) {
                activeBtn.classList.add('bg-indigo-50', 'text-indigo-600', 'shadow-sm', 'shadow-indigo-100');
                activeBtn.classList.remove('text-slate-500', 'hover:bg-gray-50');
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\penugasan-pegawai\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>