@extends('layouts.app')

@section('title', 'Edit Pegawai')

@section('content')
<div class="max-w-2xl mx-auto m-5">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Edit Pegawai</h2>
        <p class="text-gray-600 mt-1">Ubah data pegawai {{ $pegawai->name }}</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.pegawai.update', $pegawai) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NIP *</label>
                    <input type="text" name="nip" value="{{ old('nip', $pegawai->nip) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('nip')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                    <input type="text" name="name" value="{{ old('name', $pegawai->name) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $pegawai->email) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" name="password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Kosongkan jika tidak diubah">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan *</label>
                    <select name="jabatan" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Pilih Jabatan</option>
                        <option value="Staff" {{ old('jabatan', $pegawai->jabatan) == 'Staff' ? 'selected' : '' }}>Staff</option>
                        <option value="Supervisor" {{ old('jabatan', $pegawai->jabatan) == 'Supervisor' ? 'selected' : '' }}>Supervisor</option>
                        <option value="Manager" {{ old('jabatan', $pegawai->jabatan) == 'Manager' ? 'selected' : '' }}>Manager</option>
                        <option value="Koordinator" {{ old('jabatan', $pegawai->jabatan) == 'Koordinator' ? 'selected' : '' }}>Koordinator</option>
                    </select>
                    @error('jabatan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Seksi *</label>
                    <select name="seksi" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Pilih Seksi</option>
                        <option value="Umum" {{ old('seksi', $pegawai->seksi) == 'Umum' ? 'selected' : '' }}>Umum</option>
                        <option value="Keuangan" {{ old('seksi', $pegawai->seksi) == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                        <option value="SDM" {{ old('seksi', $pegawai->seksi) == 'SDM' ? 'selected' : '' }}>SDM</option>
                        <option value="Operasional" {{ old('seksi', $pegawai->seksi) == 'Operasional' ? 'selected' : '' }}>Operasional</option>
                        <option value="IT" {{ old('seksi', $pegawai->seksi) == 'IT' ? 'selected' : '' }}>IT</option>
                    </select>
                    @error('seksi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kontak *</label>
                    <input type="text" name="kontak" value="{{ old('kontak', $pegawai->kontak) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('kontak')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Max Tugas Mingguan *</label>
                    <input type="number" name="max_tugas_mingguan" value="{{ old('max_tugas_mingguan', $pegawai->max_tugas_mingguan) }}" required min="1"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('max_tugas_mingguan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Max Tugas Bulanan *</label>
                    <input type="number" name="max_tugas_bulanan" value="{{ old('max_tugas_bulanan', $pegawai->max_tugas_bulanan) }}" required min="1"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('max_tugas_bulanan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.pegawai.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection