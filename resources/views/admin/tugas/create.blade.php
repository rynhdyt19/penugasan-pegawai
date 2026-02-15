@extends('layouts.app')

@section('title', 'Tambah Tugas')

@section('content')
    <div class="max-w-3xl mx-auto py-12 px-4 animate-in fade-in slide-in-from-bottom-6 duration-700">
        <nav class="mb-4 flex items-center text-sm text-gray-400 space-x-2">
            <a href="{{ route('admin.tugas.index') }}" class="hover:text-indigo-600 transition">Data Tugas</a>
            <span>/</span>
            <span class="text-gray-900 font-bold uppercase tracking-wider text-[10px]">Tambah Baru</span>
        </nav>
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Buat Tugas Baru</h2>
            <p class="text-gray-500 mt-2 text-lg">Kelola penugasan tim Anda dengan presisi.</p>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-gray-200/60 border border-gray-100 overflow-hidden">
            <div class="p-8 sm:p-12">
                <form action="{{ route('admin.tugas.store') }}" method="POST">
                    @csrf

                    <div class="space-y-10">
                        <div>
                            <div class="flex items-center space-x-2 mb-8 border-l-4 border-indigo-500 pl-4">
                                <h3 class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-400">Informasi Dasar
                                </h3>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label
                                        class="block text-[11px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1">Nama
                                        Tugas</label>
                                    <input type="text" name="nama_tugas" value="{{ old('nama_tugas') }}" required
                                        class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-gray-900 placeholder-gray-400 shadow-inner"
                                        placeholder="Apa yang perlu dikerjakan?">
                                    @error('nama_tugas')
                                        <p class="text-red-500 text-xs mt-2 italic font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label
                                            class="block text-[11px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1">Tanggal
                                            Pelaksanaan</label>
                                        <div class="relative group">
                                            <input type="date" name="tanggal" value="{{ old('tanggal') }}" required
                                                class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-gray-900 shadow-inner">
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-[11px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1">Durasi
                                            Kerja</label>
                                        <div class="relative flex items-center">
                                            <input type="number" name="durasi" value="{{ old('durasi', 1) }}" required
                                                min="1"
                                                class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-gray-900 shadow-inner">
                                            <span
                                                class="absolute right-5 font-black text-[10px] text-gray-400 uppercase tracking-widest">Jam</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4">
                            <div class="flex items-center space-x-2 mb-8 border-l-4 border-indigo-500 pl-4">
                                <h3 class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-400">Pengaturan Tugas
                                </h3>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label
                                        class="block text-[11px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1">Lokasi</label>
                                    <div class="relative">
                                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </span>
                                        <input type="text" name="lokasi" value="{{ old('lokasi') }}" required
                                            class="w-full pl-12 pr-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-gray-900 shadow-inner"
                                            placeholder="Pilih lokasi atau input alamat">
                                    </div>
                                </div>

                                <div x-data="{
                                    open: false,
                                    selected: '{{ old('prioritas', 'sedang') }}',
                                    labels: { 'rendah': 'Rendah (Standard)', 'sedang': 'Sedang (Normal)', 'tinggi': 'Tinggi (Penting)', 'urgent': 'Urgent (Segera)' },
                                    colors: { 'rendah': 'bg-emerald-400', 'sedang': 'bg-amber-400', 'tinggi': 'bg-orange-400', 'urgent': 'bg-rose-500' }
                                }">
                                    <label
                                        class="block text-[11px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1">Tingkat
                                        Prioritas</label>
                                    <div class="relative">
                                        <button type="button" @click="open = !open"
                                            class="w-full px-5 py-4 bg-gray-50 rounded-2xl flex items-center justify-between transition-all font-bold text-gray-700 shadow-inner border-2 border-transparent focus:border-indigo-500/20">
                                            <div class="flex items-center gap-3">
                                                <span :class="colors[selected]"
                                                    class="w-3 h-3 rounded-full shadow-sm animate-pulse"></span>
                                                <span x-text="labels[selected]"></span>
                                            </div>
                                            <svg class="w-5 h-5 text-indigo-400 transition-transform duration-300"
                                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>

                                        <input type="hidden" name="prioritas" :value="selected">

                                        <div x-show="open" @click.outside="open = false"
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
                                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                            class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-[1.5rem] shadow-2xl overflow-hidden p-2">

                                            @foreach (['rendah' => 'bg-emerald-400', 'sedang' => 'bg-amber-400', 'tinggi' => 'bg-orange-400', 'urgent' => 'bg-rose-500'] as $val => $dot)
                                                <button type="button"
                                                    @click="selected = '{{ $val }}'; open = false"
                                                    class="w-full px-4 py-3 text-left hover:bg-indigo-50 rounded-xl transition-all flex items-center gap-3 group">
                                                    <span class="w-3 h-3 rounded-full {{ $dot }}"></span>
                                                    <span
                                                        class="font-bold text-gray-600 group-hover:text-indigo-600 capitalize">
                                                        {{ $val == 'rendah' ? 'Rendah (Standard)' : ($val == 'sedang' ? 'Sedang (Normal)' : ($val == 'tinggi' ? 'Tinggi (Penting)' : 'Urgent (Segera)')) }}
                                                    </span>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block text-[11px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1">Keterangan
                                        Tambahan</label>
                                    <textarea name="keterangan" rows="4"
                                        class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-gray-900 shadow-inner resize-none placeholder-gray-400"
                                        placeholder="Berikan detail instruksi pengerjaan..."></textarea>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-gradient-to-br from-indigo-600 to-violet-700 rounded-[2rem] p-8 shadow-xl shadow-indigo-200 relative overflow-hidden group">
                            <div
                                class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:bg-white/20 transition-all duration-700">
                            </div>

                            <label class="flex items-center cursor-pointer relative z-10">
                                <div class="relative">
                                    <input type="checkbox" name="auto_assign" id="auto_assign" value="1" checked
                                        class="sr-only">
                                    <div
                                        class="toggle-bg block bg-indigo-900/40 w-16 h-9 rounded-full transition-all duration-300 border border-white/20">
                                    </div>
                                    <div
                                        class="dot absolute left-1.5 top-1.5 bg-white w-6 h-6 rounded-full transition-all duration-300 shadow-lg">
                                    </div>
                                </div>
                                <div class="ml-6 flex-1 text-white">
                                    <span class="block text-base font-black tracking-wide leading-none uppercase">Smart
                                        Auto-Assignment</span>
                                    <p class="text-indigo-100/70 text-xs mt-1 font-medium">Sistem AI akan mencocokkan beban
                                        kerja pegawai secara cerdas dan merata.</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div
                        class="mt-12 flex flex-col-reverse sm:flex-row items-center justify-between gap-4 border-t border-gray-100 pt-10">
                        <a href="{{ route('admin.tugas.index') }}"
                            class="text-[11px] font-black text-gray-400 hover:text-gray-600 transition-colors uppercase tracking-[0.2em] px-4 py-2">
                            Batalkan Sesi
                        </a>
                        <button type="submit"
                            class="w-full sm:w-auto px-12 py-5 bg-indigo-600 text-white rounded-[1.5rem] font-black text-sm shadow-2xl shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-1 active:scale-95 transition-all duration-300 flex items-center justify-center uppercase tracking-widest">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            Simpan Tugas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Styling khusus toggle switch modern */
        #auto_assign:checked~.dot {
            transform: translateX(28px);
            background-color: #ffffff;
        }

        #auto_assign:checked~.toggle-bg {
            background-color: #10b981;
            /* Warna hijau sukses saat aktif */
        }

        /* Input date custom behavior */
        input[type="date"]::-webkit-calendar-picker-indicator {
            background: transparent;
            bottom: 0;
            color: transparent;
            cursor: pointer;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            width: auto;
        }
    </style>
@endsection
