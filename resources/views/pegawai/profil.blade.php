@extends('layouts.app')

@section('title', 'Profil & Pengaturan')
@section('header_title', 'Pengaturan Akun')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="mb-8">
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Profil Saya</h2>
            <p class="text-sm font-medium text-gray-500">Kelola informasi pribadi dan keamanan akun Anda</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/50">
                        <h3 class="text-lg font-bold text-gray-900">Informasi Pribadi</h3>
                    </div>

                    <form action="{{ route('pegawai.settings.update-profile') }}" method="POST" class="p-8">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">NIP</label>
                                <div class="relative">
                                    <input type="text" value="{{ Auth::user()->nip }}" disabled
                                        class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-gray-500 font-bold text-sm cursor-not-allowed">
                                    <span class="absolute right-4 top-3.5">
                                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Nama
                                    Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required
                                    class="w-full px-5 py-3.5 bg-gray-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white rounded-2xl text-gray-900 font-bold text-sm transition-all outline-none">
                                @error('name')
                                    <p class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Email
                                    Instansi</label>
                                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                                    required
                                    class="w-full px-5 py-3.5 bg-gray-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white rounded-2xl text-gray-900 font-bold text-sm transition-all outline-none">
                                @error('email')
                                    <p class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Nomor
                                    WhatsApp</label>
                                <input type="text" name="kontak" value="{{ old('kontak', Auth::user()->kontak) }}"
                                    required
                                    class="w-full px-5 py-3.5 bg-gray-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white rounded-2xl text-gray-900 font-bold text-sm transition-all outline-none">
                            </div>

                            <div class="space-y-2">
                                <label
                                    class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Jabatan</label>
                                <input type="text" value="{{ Auth::user()->jabatan }}" disabled
                                    class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-gray-500 font-bold text-sm">
                            </div>

                            <div class="space-y-2">
                                <label
                                    class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Seksi/Fungsi</label>
                                <input type="text" value="{{ Auth::user()->seksi }}" disabled
                                    class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-gray-500 font-bold text-sm">
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs uppercase tracking-widest px-8 py-4 rounded-2xl shadow-lg shadow-indigo-200 transition-all active:scale-95">
                                Simpan Profil
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/50">
                        <h3 class="text-lg font-bold text-gray-900">Keamanan Akun</h3>
                    </div>
                    <form action="{{ route('pegawai.settings.update-password') }}" method="POST" class="p-8">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Password Saat
                                    Ini</label>
                                <input type="password" name="current_password" required
                                    class="w-full px-5 py-3.5 bg-gray-50 border-2 border-transparent focus:border-red-500 focus:bg-white rounded-2xl text-gray-900 font-bold text-sm transition-all outline-none">
                            </div>
                            <div class="hidden md:block"></div>
                            <div class="space-y-2">
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Password
                                    Baru</label>
                                <input type="password" name="password" required
                                    class="w-full px-5 py-3.5 bg-gray-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white rounded-2xl text-gray-900 font-bold text-sm transition-all outline-none"
                                    placeholder="Min. 6 Karakter">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Konfirmasi
                                    Password</label>
                                <input type="password" name="password_confirmation" required
                                    class="w-full px-5 py-3.5 bg-gray-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white rounded-2xl text-gray-900 font-bold text-sm transition-all outline-none">
                            </div>
                        </div>
                        <div class="mt-8 flex justify-end">
                            <button type="submit"
                                class="bg-gray-900 hover:bg-black text-white font-black text-xs uppercase tracking-widest px-8 py-4 rounded-2xl shadow-lg shadow-gray-200 transition-all active:scale-95">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="space-y-6">
                <div
                    class="bg-indigo-600 rounded-[2rem] p-8 text-white shadow-xl shadow-indigo-100 relative overflow-hidden">
                    <svg class="absolute -right-4 -bottom-4 w-32 h-32 text-indigo-500 opacity-20" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M13 3v6h8V3h-8zm6 4h-4V5h4v2zm-6 4v10h8V11h-8zm6 8h-4v-6h4v6zm-16-7h8V3H3v8zm2-6h4v4H5V5zm-2 16h8v-8H3v8zm2-6h4v4H5v-4z" />
                    </svg>

                    <h3 class="text-lg font-bold mb-6 relative z-10">Ringkasan Kinerja</h3>
                    <div class="grid grid-cols-2 gap-6 relative z-10">
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4">
                            <p class="text-[10px] font-black uppercase tracking-widest opacity-70">Total Tugas</p>
                            <p class="text-2xl font-black mt-1">{{ $statistik['total_tugas'] }}</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4">
                            <p class="text-[10px] font-black uppercase tracking-widest opacity-70">Selesai</p>
                            <p class="text-2xl font-black mt-1">{{ $statistik['tugas_selesai'] }}</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4">
                            <p class="text-[10px] font-black uppercase tracking-widest opacity-70">Jam Kerja</p>
                            <p class="text-2xl font-black mt-1">{{ $statistik['total_jam'] }}h</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4">
                            <p class="text-[10px] font-black uppercase tracking-widest opacity-70">Bulan Ini</p>
                            <p class="text-2xl font-black mt-1">{{ $statistik['tugas_bulan_ini'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Limit Beban Kerja</h3>
                    <div class="space-y-6">
                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Maks. Mingguan
                                </p>
                                <p class="text-sm font-black text-gray-900">{{ Auth::user()->max_tugas_mingguan }} Tugas
                                </p>
                            </div>
                            <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-indigo-500 h-full rounded-full"
                                    style="width: {{ ($statistik['tugas_minggu_ini'] / max(Auth::user()->max_tugas_mingguan, 1)) * 100 }}%">
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Maks. Bulanan</p>
                                <p class="text-sm font-black text-gray-900">{{ Auth::user()->max_tugas_bulanan }} Tugas
                                </p>
                            </div>
                            <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-orange-500 h-full rounded-full"
                                    style="width: {{ ($statistik['tugas_bulan_ini'] / max(Auth::user()->max_tugas_bulanan, 1)) * 100 }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
