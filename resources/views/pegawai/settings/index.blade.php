<!-- ============================================ -->
<!-- resources/views/pegawai/settings/index.blade.php -->
<!-- ============================================ -->
@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
    <div class="p-4 sm:p-6 lg:p-8">
        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Pengaturan</h2>
            <p class="mt-1 text-sm text-gray-600">Kelola profil dan preferensi akun Anda</p>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
            <!-- Sidebar Menu -->
            <div class="xl:col-span-1">
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden sticky top-6">
                    <div class="p-4">
                        <nav class="space-y-1">
                            <button onclick="showTab('profile')" id="tab-profile"
                                class="tab-button active w-full flex items-center gap-3 px-4 py-3 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Profil Saya</span>
                            </button>

                            <button onclick="showTab('security')" id="tab-security"
                                class="tab-button w-full flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                <span>Keamanan</span>
                            </button>

                            {{-- <button onclick="showTab('notifications')" id="tab-notifications"
                                class="tab-button w-full flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 16h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                    </path>
                                </svg>
                                <span>Notifikasi</span>
                            </button>

                            <button onclick="showTab('appearance')" id="tab-appearance"
                                class="tab-button w-full flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01">
                                    </path>
                                </svg>
                                <span>Tampilan</span>
                            </button> --}}

                            <button onclick="showTab('statistics')" id="tab-statistics"
                                class="tab-button w-full flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                                <span>Statistik</span>
                            </button>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="xl:col-span-3 space-y-6">
                <!-- Profil Tab -->
                <div id="content-profile" class="tab-content">
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Informasi Profil</h3>
                            <p class="text-sm text-gray-600 mt-1">Update informasi profil dan foto Anda</p>
                        </div>

                        <div class="p-6">
                            <!-- Photo Upload -->
                            <div class="flex items-center gap-6 mb-8 pb-8 border-b border-gray-200">
                                <div class="relative">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4F46E5&color=fff&size=120"
                                        id="profile-preview" class="w-24 h-24 rounded-full ring-4 ring-gray-100">
                                    <button type="button" onclick="document.getElementById('photo-input').click()"
                                        class="absolute bottom-0 right-0 p-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition-colors shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-semibold text-gray-900 mb-1">Foto Profil</h4>
                                    <p class="text-sm text-gray-600 mb-3">Upload foto profil dengan format JPG, PNG (max
                                        2MB)</p>
                                    <form action="#" method="POST"
                                    {{-- <form action="{{ route('pegawai.settings.photo') }}" method="POST" --}}
                                        enctype="multipart/form-data" id="photo-form">
                                        @csrf
                                        <input type="file" name="photo" id="photo-input" accept="image/*"
                                            class="hidden" onchange="previewAndSubmit(this)">
                                    </form>
                                    <div class="flex gap-2">
                                        <button type="button" onclick="document.getElementById('photo-input').click()"
                                            class="px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                                            Ubah Foto
                                        </button>
                                        <form action="#" method="POST"
                                        {{-- <form action="{{ route('pegawai.settings.photo.delete') }}" method="POST" --}}
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Profile Form -->
                            <form action="#" method="POST" class="space-y-6">
                            {{-- <form action="{{ route('pegawai.settings.profile') }}" method="POST" class="space-y-6"> --}}
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">NIP</label>
                                        <input type="text" value="{{ Auth::user()->nip }}" disabled
                                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed">
                                        <p class="text-xs text-gray-500 mt-1">NIP tidak dapat diubah</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                                        <input type="text" name="name"
                                            value="{{ old('name', Auth::user()->name) }}" required
                                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                        @error('name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                        <input type="email" name="email"
                                            value="{{ old('email', Auth::user()->email) }}" required
                                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                        @error('email')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Kontak *</label>
                                        <input type="text" name="kontak"
                                            value="{{ old('kontak', Auth::user()->kontak) }}" required
                                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                        @error('kontak')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                                        <input type="text" value="{{ Auth::user()->jabatan }}" disabled
                                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Seksi</label>
                                        <input type="text" value="{{ Auth::user()->seksi }}" disabled
                                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed">
                                    </div>
                                </div>

                                <div class="flex justify-end pt-4 border-t border-gray-200">
                                    <button type="submit"
                                        class="px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Security Tab -->
                <div id="content-security" class="tab-content hidden">
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Keamanan & Password</h3>
                            <p class="text-sm text-gray-600 mt-1">Kelola password dan keamanan akun Anda</p>
                        </div>

                        <div class="p-6">
                            <form action="#" method="POST" class="space-y-6">
                            {{-- <form action="{{ route('pegawai.settings.password') }}" method="POST" class="space-y-6"> --}}
                                @csrf
                                @method('PUT')

                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <div class="flex gap-3">
                                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div>
                                            <h4 class="text-sm font-semibold text-blue-900">Tips Password Aman</h4>
                                            <ul class="text-sm text-blue-800 mt-2 space-y-1 list-disc list-inside">
                                                <li>Minimal 6 karakter</li>
                                                <li>Kombinasi huruf besar, kecil, dan angka</li>
                                                <li>Hindari informasi personal yang mudah ditebak</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini *</label>
                                    <input type="password" name="current_password" required
                                        class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    @error('current_password')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru *</label>
                                        <input type="password" name="password" required
                                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                        @error('password')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password
                                            Baru *</label>
                                        <input type="password" name="password_confirmation" required
                                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    </div>
                                </div>

                                <div class="flex justify-end pt-4 border-t border-gray-200">
                                    <button type="submit"
                                        class="px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                                        Update Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Notifications Tab -->
                <div id="content-notifications" class="tab-content hidden">
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Preferensi Notifikasi</h3>
                            <p class="text-sm text-gray-600 mt-1">Kelola bagaimana Anda menerima notifikasi</p>
                        </div>

                        <div class="p-6">
                            <form action="#" method="POST"
                            {{-- <form action="{{ route('pegawai.settings.notifications') }}" method="POST" --}}
                                class="space-y-6">
                                @csrf
                                @method('PUT')

                                <div class="space-y-4">
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div class="flex-1">
                                            <h4 class="text-sm font-semibold text-gray-900">Email Notifikasi</h4>
                                            <p class="text-sm text-gray-600 mt-0.5">Terima notifikasi melalui email</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="email_notifications" class="sr-only peer"
                                                checked>
                                            <div
                                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                            </div>
                                        </label>
                                    </div>

                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div class="flex-1">
                                            <h4 class="text-sm font-semibold text-gray-900">Pengingat Tugas</h4>
                                            <p class="text-sm text-gray-600 mt-0.5">Ingatkan saya tentang tugas yang akan
                                                datang</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="task_reminders" class="sr-only peer" checked>
                                            <div
                                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                            </div>
                                        </label>
                                    </div>

                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div class="flex-1">
                                            <h4 class="text-sm font-semibold text-gray-900">Ringkasan Mingguan</h4>
                                            <p class="text-sm text-gray-600 mt-0.5">Terima ringkasan tugas setiap minggu
                                            </p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="weekly_summary" class="sr-only peer">
                                            <div
                                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex justify-end pt-4 border-t border-gray-200">
                                    <button type="submit"
                                        class="px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                                        Simpan Preferensi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Appearance Tab -->
                <div id="content-appearance" class="tab-content hidden">
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Tampilan & Bahasa</h3>
                            <p class="text-sm text-gray-600 mt-1">Sesuaikan tampilan aplikasi sesuai preferensi Anda</p>
                        </div>

                        <div class="p-6">
                            <form action="#" method="POST" class="space-y-6">
                            {{-- <form action="{{ route('pegawai.settings.appearance') }}" method="POST" class="space-y-6"> --}}
                                @csrf
                                @method('PUT')

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Tema</label>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <label
                                            class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-indigo-500 transition-colors">
                                            <input type="radio" name="theme" value="light" class="sr-only peer"
                                                checked>
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3">
                                                    <div class="p-2 bg-white border border-gray-300 rounded-lg">
                                                        <svg class="w-6 h-6 text-yellow-500" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-semibold text-gray-900">Light</p>
                                                        <p class="text-xs text-gray-500">Tema terang</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="peer-checked:opacity-100 opacity-0 absolute top-4 right-4">
                                                <svg class="w-5 h-5 text-indigo-600" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </label>

                                        <label
                                            class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-indigo-500 transition-colors">
                                            <input type="radio" name="theme" value="dark" class="sr-only peer">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3">
                                                    <div class="p-2 bg-gray-800 border border-gray-700 rounded-lg">
                                                        <svg class="w-6 h-6 text-indigo-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-semibold text-gray-900">Dark</p>
                                                        <p class="text-xs text-gray-500">Tema gelap</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="peer-checked:opacity-100 opacity-0 absolute top-4 right-4">
                                                <svg class="w-5 h-5 text-indigo-600" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </label>

                                        <label
                                            class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-indigo-500 transition-colors">
                                            <input type="radio" name="theme" value="auto" class="sr-only peer">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="p-2 bg-gradient-to-r from-white to-gray-800 border border-gray-300 rounded-lg">
                                                        <svg class="w-6 h-6 text-gray-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.
                                                            <function_calls>
    <invoke name="artifacts">
    <parameter name="command">update</parameter>
    <parameter name="id">pegawai_settings_view</parameter>
    <parameter name="old_str">                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="
                                                                M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4
                                                                12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072
                                                                0l-.</parameter>
                                                                <parameter name="new_str">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                                                    </path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-semibold text-gray-900">Auto</p>
                                                        <p class="text-xs text-gray-500">Ikuti sistem</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="peer-checked:opacity-100 opacity-0 absolute top-4 right-4">
                                                <svg class="w-5 h-5 text-indigo-600" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Bahasa</label>
                                    <select name="language"
                                        class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option value="id" selected>Bahasa Indonesia</option>
                                        <option value="en">English</option>
                                    </select>
                                </div>

                                <div class="flex justify-end pt-4 border-t border-gray-200">
                                    <button type="submit"
                                        class="px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                                        Simpan Pengaturan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Statistics Tab -->
                <div id="content-statistics" class="tab-content hidden">
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Statistik Kinerja</h3>
                            <p class="text-sm text-gray-600 mt-1">Ringkasan performa dan pencapaian Anda</p>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                                <div
                                    class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-5 border border-blue-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="p-2 bg-blue-600 rounded-lg">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-2xl font-bold text-blue-900">{{ $statistik['total_tugas'] }}</p>
                                    <p class="text-sm text-blue-700 mt-1">Total Tugas</p>
                                </div>

                                <div
                                    class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-5 border border-green-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="p-2 bg-green-600 rounded-lg">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-2xl font-bold text-green-900">{{ $statistik['tugas_selesai'] }}</p>
                                    <p class="text-sm text-green-700 mt-1">Tugas Selesai</p>
                                </div>

                                <div
                                    class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-5 border border-purple-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="p-2 bg-purple-600 rounded-lg">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-2xl font-bold text-purple-900">{{ $statistik['total_jam'] }}</p>
                                    <p class="text-sm text-purple-700 mt-1">Total Jam Kerja</p>
                                </div>

                                <div
                                    class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-5 border border-orange-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="p-2 bg-orange-600 rounded-lg">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-2xl font-bold text-orange-900">{{ $statistik['tugas_bulan_ini'] }}</p>
                                    <p class="text-sm text-orange-700 mt-1">Tugas Bulan Ini</p>
                                </div>

                                <div
                                    class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-xl p-5 border border-pink-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="p-2 bg-pink-600 rounded-lg">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-2xl font-bold text-pink-900">{{ $statistik['tugas_minggu_ini'] }}</p>
                                    <p class="text-sm text-pink-700 mt-1">Tugas Minggu Ini</p>
                                </div>

                                <div
                                    class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-5 border border-indigo-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="p-2 bg-indigo-600 rounded-lg">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-2xl font-bold text-indigo-900">
                                        {{ $statistik['tugas_selesai'] > 0 ? round(($statistik['tugas_selesai'] / $statistik['total_tugas']) * 100, 1) : 0 }}%
                                    </p>
                                    <p class="text-sm text-indigo-700 mt-1">Tingkat Penyelesaian</p>
                                </div>
                            </div>

                            <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-indigo-600 flex-shrink-0 mt-0.5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                        </path>
                                    </svg>
                                    <div>
                                        <h4 class="text-sm font-semibold text-indigo-900">Pencapaian</h4>
                                        <p class="text-sm text-indigo-800 mt-1">
                                            Tingkat penyelesaian tugas Anda sangat baik! Terus pertahankan performa Anda.
                                        </p>
                                    </div>
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
            // Hide all content
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active class from all buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active', 'text-indigo-600', 'bg-indigo-50');
                button.classList.add('text-gray-700');
            });

            // Show selected content
            document.getElementById('content-' + tabName).classList.remove('hidden');

            // Add active class to selected button
            const activeButton = document.getElementById('tab-' + tabName);
            activeButton.classList.add('active', 'text-indigo-600', 'bg-indigo-50');
            activeButton.classList.remove('text-gray-700');
        }

        function previewAndSubmit(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-preview').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);

                // Auto submit form
                document.getElementById('photo-form').submit();
            }
        }
    </script>
    <style>
        .tab-button.active {
            background-color: rgb(238 242 255);
            color: rgb(79 70 229);
        }
    </style>
@endsection
</parameter>
