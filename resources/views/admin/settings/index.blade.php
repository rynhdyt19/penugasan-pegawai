<!-- ============================================ -->
<!-- resources/views/admin/settings/index.blade.php -->
<!-- ============================================ -->
@extends('layouts.app')

@section('title', 'Settings - Admin')

@section('content')
    <div class="p-8">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Settings</h2>
            <p class="text-gray-600 mt-1">Kelola profil dan preferensi akun Anda</p>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
                <div class="flex">
                    <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <p class="ml-3 text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
                <div class="flex">
                    <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3">
                        @foreach ($errors->all() as $error)
                            <p class="text-sm text-red-700">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Sidebar Tabs -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-4">
                        <nav class="space-y-1">
                            <button onclick="showTab('profile')" id="tab-profile"
                                class="tab-button w-full flex items-center space-x-3 px-4 py-3 text-sm font-medium rounded-lg bg-indigo-50 text-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Profil</span>
                            </button>
                            <button onclick="showTab('password')" id="tab-password"
                                class="tab-button w-full flex items-center space-x-3 px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                <span>Password</span>
                            </button>
                            <button onclick="showTab('notifications')" id="tab-notifications"
                                class="tab-button w-full flex items-center space-x-3 px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                    </path>
                                </svg>
                                <span>Notifikasi</span>
                            </button>
                            <button onclick="showTab('stats')" id="tab-stats"
                                class="tab-button w-full flex items-center space-x-3 px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">
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
            <div class="lg:col-span-3">
                <!-- Profile Tab -->
                <div id="content-profile" class="tab-content">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Informasi Profil</h3>
                        </div>
                        <div class="p-6">
                            <!-- Photo Upload -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Foto Profil</label>
                                <div class="flex items-center space-x-4">
                                    @if (Auth::user()->photo)
                                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile Photo"
                                            class="w-20 h-20 rounded-full object-cover ring-2 ring-gray-200">
                                    @else
                                        <div
                                            class="w-20 h-20 rounded-full bg-indigo-100 flex items-center justify-center ring-2 ring-gray-200">
                                            <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <form action="{{ route('admin.settings.update-photo') }}" method="POST"
                                            enctype="multipart/form-data" class="inline-block">
                                            @csrf
                                            <input type="file" name="photo" id="photo" class="hidden"
                                                accept="image/*" onchange="this.form.submit()">
                                            <label for="photo"
                                                class="cursor-pointer inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12">
                                                    </path>
                                                </svg>
                                                Upload Foto
                                            </label>
                                        </form>
                                        @if (Auth::user()->photo)
                                            <form action="{{ route('admin.settings.delete-photo') }}" method="POST"
                                                class="inline-block ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700"
                                                    onclick="return confirm('Hapus foto profil?')">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                        <p class="text-xs text-gray-500 mt-2">JPG, PNG maksimal 2MB</p>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-6">

                            <!-- Profile Form -->
                            <form action="{{ route('admin.settings.update-profile') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                        <input type="text" name="name"
                                            value="{{ old('name', Auth::user()->name) }}"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                            required>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                        <input type="email" name="email"
                                            value="{{ old('email', Auth::user()->email) }}"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                            required>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Kontak/No. HP</label>
                                        <input type="text" name="kontak"
                                            value="{{ old('kontak', Auth::user()->kontak) }}"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                        <input type="text" value="{{ ucfirst(Auth::user()->role) }}"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50" disabled>
                                    </div>
                                </div>

                                <div class="mt-6 flex justify-end">
                                    <button type="submit"
                                        class="inline-flex items-center px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Password Tab -->
                <div id="content-password" class="tab-content hidden">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Ubah Password</h3>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('admin.settings.update-password') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Password Saat
                                            Ini</label>
                                        <input type="password" name="current_password"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                            required>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                                        <input type="password" name="password"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                            required>
                                        <p class="text-xs text-gray-500 mt-1">Minimal 6 karakter</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password
                                            Baru</label>
                                        <input type="password" name="password_confirmation"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                            required>
                                    </div>
                                </div>

                                <div class="mt-6 flex justify-end">
                                    <button type="submit"
                                        class="inline-flex items-center px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Ubah Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Notifications Tab -->
                <div id="content-notifications" class="tab-content hidden">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Preferensi Notifikasi</h3>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('admin.settings.update-notifications') }}" method="POST">
                                @csrf
                                @method('PUT')

                                @php
                                    $preferences = json_decode(Auth::user()->notification_preferences ?? '{}', true);
                                @endphp

                                <div class="space-y-4">
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="email_notifications" id="email_notifications"
                                                {{ $preferences['email_notifications'] ?? true ? 'checked' : '' }}
                                                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3">
                                            <label for="email_notifications" class="font-medium text-gray-700">Notifikasi
                                                Email</label>
                                            <p class="text-sm text-gray-500">Terima notifikasi melalui email</p>
                                        </div>
                                    </div>

                                    {{-- <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="task_reminders" id="task_reminders"
                                                {{ $preferences['task_reminders'] ?? true ? 'checked' : '' }}
                                                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3">
                                            <label for="task_reminders" class="font-medium text-gray-700">Pengingat
                                                Tugas</label>
                                            <p class="text-sm text-gray-500">Ingatkan tentang tugas yang belum selesai</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="weekly_summary" id="weekly_summary"
                                                {{ $preferences['weekly_summary'] ?? false ? 'checked' : '' }}
                                                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3">
                                            <label for="weekly_summary" class="font-medium text-gray-700">Ringkasan
                                                Mingguan</label>
                                            <p class="text-sm text-gray-500">Terima ringkasan aktivitas setiap minggu</p>
                                        </div>
                                    </div> --}}

                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="system_alerts" id="system_alerts"
                                                {{ $preferences['system_alerts'] ?? true ? 'checked' : '' }}
                                                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3">
                                            <label for="system_alerts" class="font-medium text-gray-700">Alert
                                                Sistem</label>
                                            <p class="text-sm text-gray-500">Pemberitahuan tentang update dan perubahan
                                                sistem</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 flex justify-end">
                                    <button type="submit"
                                        class="inline-flex items-center px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Simpan Preferensi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Appearance Tab -->
                <div id="content-appearance" class="tab-content hidden">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Pengaturan Tampilan</h3>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('admin.settings.update-appearance') }}" method="POST">
                                @csrf
                                @method('PUT')

                                @php
                                    $appearance = json_decode(Auth::user()->preferences ?? '{}', true);
                                @endphp

                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Tema</label>
                                        <select name="theme"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                            <option value="light"
                                                {{ ($appearance['theme'] ?? 'light') == 'light' ? 'selected' : '' }}>Terang
                                            </option>
                                            <option value="dark"
                                                {{ ($appearance['theme'] ?? 'light') == 'dark' ? 'selected' : '' }}>Gelap
                                            </option>
                                            <option value="auto"
                                                {{ ($appearance['theme'] ?? 'light') == 'auto' ? 'selected' : '' }}>
                                                Otomatis (Ikuti Sistem)</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Bahasa</label>
                                        <select name="language"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                            <option value="id"
                                                {{ ($appearance['language'] ?? 'id') == 'id' ? 'selected' : '' }}>Bahasa
                                                Indonesia</option>
                                            <option value="en"
                                                {{ ($appearance['language'] ?? 'id') == 'en' ? 'selected' : '' }}>English
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-6 flex justify-end">
                                    <button type="submit"
                                        class="inline-flex items-center px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Simpan Pengaturan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Statistics Tab -->
                <div id="content-stats" class="tab-content hidden">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Statistik Sistem</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-blue-600">Total Pegawai</p>
                                            <p class="text-3xl font-bold text-blue-900 mt-2">
                                                {{ $statistik['total_pegawai'] ?? 0 }}</p>
                                        </div>
                                        <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>

                                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-6 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-indigo-600">Total Tugas</p>
                                            <p class="text-3xl font-bold text-indigo-900 mt-2">
                                                {{ $statistik['total_tugas'] ?? 0 }}</p>
                                        </div>
                                        <svg class="w-12 h-12 text-indigo-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                            </path>
                                        </svg>
                                    </div>
                                </div>

                                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-6 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-yellow-600">Tugas Aktif</p>
                                            <p class="text-3xl font-bold text-yellow-900 mt-2">
                                                {{ $statistik['tugas_aktif'] ?? 0 }}</p>
                                        </div>
                                        <svg class="w-12 h-12 text-yellow-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>

                                <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-green-600">Tugas Selesai</p>
                                            <p class="text-3xl font-bold text-green-900 mt-2">
                                                {{ $statistik['tugas_selesai'] ?? 0 }}</p>
                                        </div>
                                        <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>

                                <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-purple-600">Total Jam Tugas</p>
                                            <p class="text-3xl font-bold text-purple-900 mt-2">
                                                {{ number_format($statistik['total_jam_tugas'] ?? 0, 1) }}</p>
                                        </div>
                                        <svg class="w-12 h-12 text-purple-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
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
                button.classList.remove('bg-indigo-50', 'text-indigo-600');
                button.classList.add('text-gray-700', 'hover:bg-gray-50');
            });

            // Show selected content
            document.getElementById('content-' + tabName).classList.remove('hidden');

            // Add active class to selected button
            const activeButton = document.getElementById('tab-' + tabName);
            activeButton.classList.add('bg-indigo-50', 'text-indigo-600');
            activeButton.classList.remove('text-gray-700', 'hover:bg-gray-50');
        }
    </script>
@endsection
