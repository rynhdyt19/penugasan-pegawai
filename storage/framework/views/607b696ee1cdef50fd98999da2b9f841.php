

<?php $__env->startSection('title', 'Pengaturan Akun'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h2 class="text-3xl font-black text-gray-900 tracking-tight">Pengaturan</h2>
            <p class="mt-2 text-sm font-medium text-gray-500">Kelola identitas digital, keamanan, dan pantau performa kerja
                Anda</p>
        </div>

        <?php if(session('success')): ?>
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-emerald-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="text-emerald-800 text-sm font-bold"><?php echo e(session('success')); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
            <div class="xl:col-span-1">
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden sticky top-8">
                    <div class="p-4 space-y-2">
                        <button onclick="showTab('profile')" id="tab-profile"
                            class="tab-button active w-full flex items-center gap-3 px-5 py-4 text-sm font-bold text-indigo-600 bg-indigo-50 rounded-2xl transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>Profil Saya</span>
                        </button>

                        <button onclick="showTab('security')" id="tab-security"
                            class="tab-button w-full flex items-center gap-3 px-5 py-4 text-sm font-bold text-gray-500 hover:bg-gray-50 rounded-2xl transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                            <span>Keamanan</span>
                        </button>

                        <button onclick="showTab('statistics')" id="tab-statistics"
                            class="tab-button w-full flex items-center gap-3 px-5 py-4 text-sm font-bold text-gray-500 hover:bg-gray-50 rounded-2xl transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            <span>Statistik Kinerja</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="xl:col-span-3">
                <div id="content-profile" class="tab-content transition-all duration-300">
                    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/50">
                            <h3 class="text-lg font-black text-gray-900 uppercase tracking-wider">Informasi Profil</h3>
                        </div>

                        <div class="p-8">
                            <div class="flex flex-col md:flex-row items-center gap-8 mb-10 pb-10 border-b border-gray-50">
                                <div class="relative group">
                                    <img src="<?php echo e(Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=4F46E5&color=fff&size=200'); ?>"
                                        id="profile-preview"
                                        class="w-32 h-32 rounded-[2.5rem] object-cover ring-4 ring-indigo-50 transition-transform duration-500 group-hover:scale-105">

                                    <button type="button" onclick="document.getElementById('photo-input').click()"
                                        class="absolute -bottom-2 -right-2 p-3 bg-indigo-600 text-white rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-200 active:scale-90">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"   
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div class="text-center md:text-left space-y-4">
                                    <div>
                                        <h4 class="text-md font-black text-gray-900">Avatar Akun</h4>
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">PNG, JPG
                                            atau GIF (Maks. 2MB)</p>
                                    </div>

                                    <div class="flex flex-wrap justify-center md:justify-start gap-3">
                                        <form action="<?php echo e(route('pegawai.settings.update-photo')); ?>" method="POST"
                                            enctype="multipart/form-data" id="photo-form">
                                            <?php echo csrf_field(); ?>
                                            <input type="file" name="photo" id="photo-input" accept="image/*"
                                                class="hidden" onchange="this.form.submit()">
                                            <button type="button" onclick="document.getElementById('photo-input').click()"
                                                class="px-5 py-2.5 text-xs font-black uppercase tracking-widest text-indigo-600 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition-all">
                                                Upload Baru
                                            </button>
                                        </form>

                                        <?php if(Auth::user()->photo): ?>
                                            <form action="<?php echo e(route('pegawai.settings.delete-photo')); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit"
                                                    class="px-5 py-2.5 text-xs font-black uppercase tracking-widest text-red-600 bg-red-50 rounded-xl hover:bg-red-100 transition-all">
                                                    Hapus
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <form action="<?php echo e(route('pegawai.settings.update-profile')); ?>" method="POST" class="space-y-8">
                                <?php echo csrf_field(); ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                                    <div class="space-y-2">
                                        <label
                                            class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">NIP
                                            (Terkunci)</label>
                                        <div class="relative">
                                            <input type="text" value="<?php echo e(Auth::user()->nip); ?>" disabled
                                                class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl text-gray-400 font-bold text-sm cursor-not-allowed">
                                            <svg class="w-4 h-4 absolute right-4 top-4 text-gray-300" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <label
                                            class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">Nama
                                            Lengkap</label>
                                        <input type="text" name="name"
                                            value="<?php echo e(old('name', Auth::user()->name)); ?>" required
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white rounded-2xl text-gray-900 font-bold text-sm transition-all outline-none">
                                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="text-red-500 text-[10px] font-bold mt-1 ml-1"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="space-y-2">
                                        <label
                                            class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">Email
                                            Instansi</label>
                                        <input type="email" name="email"
                                            value="<?php echo e(old('email', Auth::user()->email)); ?>" required
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white rounded-2xl text-gray-900 font-bold text-sm transition-all outline-none">
                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="text-red-500 text-[10px] font-bold mt-1 ml-1"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="space-y-2">
                                        <label
                                            class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">No.
                                            WhatsApp</label>
                                        <input type="text" name="kontak"
                                            value="<?php echo e(old('kontak', Auth::user()->kontak)); ?>" required
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white rounded-2xl text-gray-900 font-bold text-sm transition-all outline-none">
                                    </div>

                                    <div class="space-y-2">
                                        <label
                                            class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">Jabatan</label>
                                        <input type="text" value="<?php echo e(Auth::user()->jabatan); ?>" disabled
                                            class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl text-gray-500 font-bold text-sm">
                                    </div>

                                    <div class="space-y-2">
                                        <label
                                            class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">Seksi
                                            / Fungsi</label>
                                        <input type="text" value="<?php echo e(Auth::user()->seksi); ?>" disabled
                                            class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl text-gray-500 font-bold text-sm">
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="px-10 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-indigo-100 transition-all active:scale-95">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="content-security" class="tab-content hidden transition-all duration-300">
                    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/50">
                            <h3 class="text-lg font-black text-gray-900 uppercase tracking-wider">Keamanan Akun</h3>
                        </div>

                        <div class="p-8">
                            <form action="<?php echo e(route('pegawai.settings.update-password')); ?>" method="POST"
                                class="space-y-8">
                                <?php echo csrf_field(); ?>
                                <div class="p-6 bg-indigo-600 rounded-[2rem] text-white relative overflow-hidden">
                                    <svg class="w-24 h-24 absolute -right-6 -bottom-6 opacity-10" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M2.166 4.9L9.03 9.125a2.483 2.483 0 002.144 0L18.04 4.9A2.486 2.486 0 0016.14 2H4.06a2.486 2.486 0 00-1.894 2.9zM18 7.062V15.5a2.5 2.5 0 01-2.5 2.5h-11A2.5 2.5 0 012 15.5V7.062l6.235 3.835a4.49 4.49 0 004.53 0L18 7.062z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <h4 class="text-sm font-black uppercase tracking-widest mb-3">Keamanan Password</h4>
                                    <ul class="text-xs space-y-2 font-bold opacity-90">
                                        <li class="flex items-center"><span
                                                class="w-1.5 h-1.5 bg-white rounded-full mr-2"></span> Minimal 6 Karakter
                                        </li>
                                        <li class="flex items-center"><span
                                                class="w-1.5 h-1.5 bg-white rounded-full mr-2"></span> Gunakan kombinasi
                                            angka & simbol</li>
                                    </ul>
                                </div>

                                <div class="space-y-6 uppercase tracking-wider">
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black text-gray-400">Password Saat Ini</label>
                                        <input type="password" name="current_password" required
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-transparent focus:border-red-400 focus:bg-white rounded-2xl text-gray-900 font-bold text-sm transition-all outline-none">
                                        <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="text-red-500 text-[10px] font-bold mt-1"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black text-gray-400">Password Baru</label>
                                            <input type="password" name="password" required
                                                class="w-full px-5 py-4 bg-gray-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white rounded-2xl text-gray-900 font-bold text-sm transition-all outline-none">
                                        </div>

                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black text-gray-400">Konfirmasi Password</label>
                                            <input type="password" name="password_confirmation" required
                                                class="w-full px-5 py-4 bg-gray-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white rounded-2xl text-gray-900 font-bold text-sm transition-all outline-none">
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-end pt-4">
                                    <button type="submit"
                                        class="px-10 py-4 bg-gray-900 hover:bg-black text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-gray-100 transition-all active:scale-95">
                                        Perbarui Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="content-statistics" class="tab-content hidden transition-all duration-300">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div
                            class="bg-indigo-600 rounded-[2.5rem] p-8 text-white shadow-xl shadow-indigo-100 relative overflow-hidden">
                            <svg class="absolute -right-4 -bottom-4 w-32 h-32 text-indigo-500 opacity-20"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                            </svg>
                            <p class="text-[10px] font-black uppercase tracking-widest opacity-70">Total Penugasan</p>
                            <h4 class="text-5xl font-black mt-2"><?php echo e($statistik['total_tugas']); ?></h4>
                            <p class="text-xs font-bold mt-4 opacity-80">Akumulasi seluruh tugas yang diterima</p>
                        </div>

                        <div
                            class="bg-emerald-500 rounded-[2.5rem] p-8 text-white shadow-xl shadow-emerald-100 relative overflow-hidden">
                            <svg class="absolute -right-4 -bottom-4 w-32 h-32 text-emerald-400 opacity-20"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <p class="text-[10px] font-black uppercase tracking-widest opacity-70">Tugas Selesai</p>
                            <h4 class="text-5xl font-black mt-2"><?php echo e($statistik['tugas_selesai']); ?></h4>
                            <p class="text-xs font-bold mt-4 opacity-80">Tingkat penyelesaian tugas Anda</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm p-8">
                        <h3 class="text-lg font-black text-gray-900 uppercase tracking-wider mb-8">Batas Beban Kerja</h3>
                        <div class="space-y-10">
                            <div class="space-y-4">
                                <div class="flex justify-between items-end">
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Minggu
                                            Ini</p>
                                        <p class="text-lg font-black text-gray-900"><?php echo e($statistik['tugas_minggu_ini']); ?> /
                                            <?php echo e(Auth::user()->max_tugas_mingguan); ?> <span
                                                class="text-xs text-gray-400 font-bold ml-1">TUGAS</span></p>
                                    </div>
                                    <?php $percMinggu = ($statistik['tugas_minggu_ini'] / max(Auth::user()->max_tugas_mingguan, 1)) * 100; ?>
                                    <span
                                        class="text-xs font-black text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full"><?php echo e(round($percMinggu)); ?>%</span>
                                </div>
                                <div class="w-full bg-gray-50 h-4 rounded-full overflow-hidden">
                                    <div class="bg-indigo-500 h-full rounded-full transition-all duration-1000 shadow-sm"
                                        style="width: <?php echo e($percMinggu); ?>%"></div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="flex justify-between items-end">
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Bulan Ini
                                        </p>
                                        <p class="text-lg font-black text-gray-900"><?php echo e($statistik['tugas_bulan_ini']); ?> /
                                            <?php echo e(Auth::user()->max_tugas_bulanan); ?> <span
                                                class="text-xs text-gray-400 font-bold ml-1">TUGAS</span></p>
                                    </div>
                                    <?php $percBulan = ($statistik['tugas_bulan_ini'] / max(Auth::user()->max_tugas_bulanan, 1)) * 100; ?>
                                    <span
                                        class="text-xs font-black text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full"><?php echo e(round($percBulan)); ?>%</span>
                                </div>
                                <div class="w-full bg-gray-50 h-4 rounded-full overflow-hidden">
                                    <div class="bg-emerald-500 h-full rounded-full transition-all duration-1000 shadow-sm"
                                        style="width: <?php echo e($percBulan); ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all contents
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));

            // Show selected content
            document.getElementById('content-' + tabName).classList.remove('hidden');

            // Update buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active', 'text-indigo-600', 'bg-indigo-50');
                btn.classList.add('text-gray-500');
            });

            const activeBtn = document.getElementById('tab-' + tabName);
            activeBtn.classList.add('active', 'text-indigo-600', 'bg-indigo-50');
            activeBtn.classList.remove('text-gray-500');
        }
    </script>

    <style>
        .tab-button.active {
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.1), 0 2px 4px -1px rgba(79, 70, 229, 0.06);
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\penugasan-pegawai\resources\views/pegawai/settings/index.blade.php ENDPATH**/ ?>