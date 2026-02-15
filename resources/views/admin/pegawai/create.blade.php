@extends('layouts.app')

@section('title', 'Tambah Pegawai')

@section('content')
    <div class="max-w-4xl mx-auto animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Tambah Pegawai</h2>
                <p class="text-gray-500 mt-1 italic">Daftarkan personel baru ke dalam sistem manajemen tugas.</p>
            </div>
            <a href="{{ route('admin.pegawai.index') }}"
                class="text-sm font-bold text-gray-400 hover:text-indigo-600 transition-colors flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 8 8 0 01-18 0z"></path>
                </svg>
                KEMBALI
            </a>
        </div>

        <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-100/50 border border-gray-100 overflow-hidden">
            <form action="{{ route('admin.pegawai.store') }}" method="POST" class="p-8 md:p-10">
                @csrf
                <div class="space-y-8">

                    <section>
                        <h3
                            class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-500 mb-6 flex items-center">
                            <span class="w-8 h-px bg-indigo-200 mr-3"></span>
                            Identitas Utama
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">NIP <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="nip" value="{{ old('nip') }}" required
                                    class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-gray-900"
                                    placeholder="19900101XXXXXXXXXX">
                                @error('nip')
                                    <p class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Nama
                                    Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                    class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-gray-900"
                                    placeholder="Masukkan nama tanpa gelar">
                                @error('name')
                                    <p class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <section>
                        <h3
                            class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-500 mb-6 flex items-center">
                            <span class="w-8 h-px bg-indigo-200 mr-3"></span>
                            Akses & Komunikasi
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="space-y-1">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Email
                                    <span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-gray-900"
                                    placeholder="user@instansi.go.id">
                                @error('email')
                                    <p class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Password
                                    <span class="text-red-500">*</span></label>
                                <input type="password" name="password" required
                                    class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-gray-900"
                                    placeholder="Minimal 6 karakter">
                                @error('password')
                                    <p class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">No.
                                    WhatsApp <span class="text-red-500">*</span></label>
                                <input type="text" name="kontak" value="{{ old('kontak') }}" required
                                    class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-gray-900"
                                    placeholder="0812XXXXXXXX">
                                @error('kontak')
                                    <p class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <section>
                        <h3
                            class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-500 mb-6 flex items-center">
                            <span class="w-8 h-px bg-indigo-200 mr-3"></span>
                            Penempatan & Limit Kerja
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1" x-data="{ open: false, selected: '{{ old('jabatan', 'Pilih Jabatan') }}' }">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Jabatan
                                    <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <button type="button" @click="open = !open"
                                        class="w-full px-4 py-3 bg-gray-50 border-2 border-transparent focus:border-indigo-400 rounded-[1.5rem] flex items-center justify-between transition-all font-bold text-gray-700 shadow-sm">
                                        <div class="flex items-center gap-3">
                                            <span x-show="selected !== 'Pilih Jabatan'"
                                                class="w-3 h-3 rounded-full bg-indigo-500"></span>
                                            <span x-text="selected"></span>
                                        </div>
                                        <svg class="w-5 h-5 text-indigo-400 transition-transform"
                                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <input type="hidden" name="jabatan"
                                        :value="selected === 'Pilih Jabatan' ? '' : selected">
                                    <div x-show="open" @click.outside="open = false" x-transition
                                        class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-[1.5rem] shadow-xl overflow-hidden">
                                        <div
                                            class="bg-gray-50 px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-400 border-b border-gray-100">
                                            Daftar Jabatan</div>
                                        @foreach (['Staff', 'Supervisor', 'Manager', 'Koordinator'] as $j)
                                            <button type="button" @click="selected = '{{ $j }}'; open = false"
                                                class="w-full px-4 py-3 text-left hover:bg-indigo-50 hover:text-indigo-600 transition-all flex items-center gap-3 group">
                                                <span
                                                    class="w-3 h-3 rounded-full bg-gray-300 group-hover:bg-indigo-500 transition-colors"></span>
                                                <span
                                                    class="font-bold text-gray-600 group-hover:text-indigo-700">{{ $j }}</span>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                                @error('jabatan')
                                    <p class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1" x-data="{
                                open: false,
                                selected: '{{ old('seksi', 'Pilih Seksi') }}',
                                colors: { 'Umum': 'bg-emerald-400', 'Keuangan': 'bg-amber-400', 'SDM': 'bg-rose-400', 'Operasional': 'bg-blue-400', 'IT': 'bg-indigo-400' }
                            }">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Seksi
                                    <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <button type="button" @click="open = !open"
                                        class="w-full px-4 py-3 bg-gray-50 border-2 border-transparent focus:border-indigo-400 rounded-[1.5rem] flex items-center justify-between transition-all font-bold text-gray-700 shadow-sm">
                                        <div class="flex items-center gap-3">
                                            <span x-show="selected !== 'Pilih Seksi'"
                                                :class="colors[selected] || 'bg-gray-400'"
                                                class="w-3 h-3 rounded-full shadow-sm"></span>
                                            <span x-text="selected"></span>
                                        </div>
                                        <svg class="w-5 h-5 text-indigo-400 transition-transform"
                                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <input type="hidden" name="seksi"
                                        :value="selected === 'Pilih Seksi' ? '' : selected">
                                    <div x-show="open" @click.outside="open = false" x-transition
                                        class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-[1.5rem] shadow-xl overflow-hidden">
                                        @foreach (['Umum', 'Keuangan', 'SDM', 'Operasional', 'IT'] as $s)
                                            <button type="button"
                                                @click="selected = '{{ $s }}'; open = false"
                                                class="w-full px-4 py-3 text-left hover:bg-indigo-600 hover:text-white transition-all flex items-center gap-3 group">
                                                <span
                                                    class="w-3 h-3 rounded-full border border-white/20 shadow-sm {{ ['Umum' => 'bg-emerald-400', 'Keuangan' => 'bg-amber-400', 'SDM' => 'bg-rose-400', 'Operasional' => 'bg-blue-400', 'IT' => 'bg-indigo-400'][$s] }}"></span>
                                                <span
                                                    class="font-bold text-gray-600 group-hover:text-white">{{ $s }}</span>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                                @error('seksi')
                                    <p class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div
                            class="mt-6 grid grid-cols-2 gap-4 bg-indigo-50/50 p-4 rounded-[1.5rem] border border-indigo-100">
                            <div class="space-y-1">
                                <label class="text-[10px] font-black uppercase tracking-tighter text-indigo-400 ml-1">Max
                                    Mingguan</label>
                                <input type="number" name="max_tugas_mingguan"
                                    value="{{ old('max_tugas_mingguan', 5) }}" required min="1"
                                    class="w-full px-4 py-2 bg-white border-none rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-black text-indigo-600">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-black uppercase tracking-tighter text-indigo-400 ml-1">Max
                                    Bulanan</label>
                                <input type="number" name="max_tugas_bulanan"
                                    value="{{ old('max_tugas_bulanan', 20) }}" required min="1"
                                    class="w-full px-4 py-2 bg-white border-none rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-black text-indigo-600">
                            </div>
                        </div>
                    </section>
                </div>

                <div class="mt-12 pt-8 border-t border-gray-50 flex flex-col sm:flex-row gap-3">
                    <button type="submit"
                        class="flex-1 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-sm transition-all shadow-lg shadow-indigo-200 transform hover:-translate-y-1 uppercase tracking-widest">
                        Simpan Data Pegawai
                    </button>
                    <a href="{{ route('admin.pegawai.index') }}"
                        class="flex-1 py-4 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-2xl font-black text-sm transition-all text-center uppercase tracking-widest flex items-center justify-center">
                        Batalkan
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
