@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <div class="px-4 sm:px-0">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Profil Saya</h2>
            <p class="text-gray-600 mt-1">Kelola informasi profil Anda</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form Profil -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Informasi Pribadi</h3>

                    <form action="{{ route('pegawai.profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">NIP</label>
                                    <input type="text" value="{{ Auth::user()->nip }}" disabled
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-500">
                                    <p class="text-xs text-gray-500 mt-1">NIP tidak dapat diubah</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Kontak *</label>
                                    <input type="text" name="kontak" value="{{ old('kontak', Auth::user()->kontak) }}"
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                                    @error('kontak')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                                    <input type="text" value="{{ Auth::user()->jabatan }}" disabled
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Seksi</label>
                                    <input type="text" value="{{ Auth::user()->seksi }}" disabled
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-500">
                                </div>
                            </div>

                            <hr class="my-6">

                            <h4 class="text-base font-semibold text-gray-900 mb-4">Ubah Password</h4>
                            <p class="text-sm text-gray-600 mb-4">Kosongkan jika tidak ingin mengubah password</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                                    <input type="password" name="password"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                                        placeholder="Minimal 6 karakter">
                                    @error('password')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                                        placeholder="Ulangi password baru">
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Statistik -->
            <div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik Kinerja</h3>

                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-600">Total Tugas</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $statistik['total_tugas'] }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">Tugas Selesai</p>
                            <p class="text-2xl font-bold text-green-600">{{ $statistik['tugas_selesai'] }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">Total Jam Kerja</p>
                            <p class="text-2xl font-bold text-purple-600">{{ $statistik['total_jam'] }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">Tugas Bulan Ini</p>
                            <p class="text-2xl font-bold text-orange-600">{{ $statistik['tugas_bulan_ini'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Batas Beban Kerja</h3>

                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600">Max Tugas Mingguan</p>
                            <p class="text-xl font-bold text-gray-900">{{ Auth::user()->max_tugas_mingguan }} tugas</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">Max Tugas Bulanan</p>
                            <p class="text-xl font-bold text-gray-900">{{ Auth::user()->max_tugas_bulanan }} tugas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
