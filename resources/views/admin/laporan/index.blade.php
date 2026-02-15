@extends('layouts.app')

@section('title', 'Laporan & Monitoring')

@section('content')
    <div class="space-y-8 animate-in fade-in duration-700">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-100 pb-6">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Laporan & Monitoring</h2>
                <p class="text-gray-500 mt-1">Analisis data penugasan dan unduh laporan performa pegawai.</p>
            </div>
            <div class="flex items-center gap-2 text-sm font-medium text-indigo-600 bg-indigo-50 px-4 py-2 rounded-full">
                <span class="relative flex h-2 w-2">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                </span>
                Data diperbarui secara Real-time
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <a href="{{ route('admin.laporan.rekap') }}"
                class="group relative bg-white rounded-3xl p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:border-indigo-100 transition-all duration-300 overflow-hidden">
                <div class="relative z-10 flex items-start gap-6">
                    <div
                        class="p-4 rounded-2xl bg-blue-50 text-blue-600 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Rekap Penugasan</h3>
                        <p class="text-gray-500 text-sm leading-relaxed mb-6">Tinjau daftar lengkap penugasan per pegawai.
                            Filter berdasarkan periode untuk audit internal.</p>
                        <span
                            class="inline-flex items-center text-sm font-bold text-blue-600 group-hover:translate-x-2 transition-transform">
                            Buka Laporan Rekap <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </span>
                    </div>
                </div>
                <div
                    class="absolute -right-4 -bottom-4 w-24 h-24 bg-blue-50/50 rounded-full blur-2xl group-hover:bg-blue-100 transition-colors">
                </div>
            </a>

            <a href="{{ route('admin.laporan.statistik') }}"
                class="group relative bg-white rounded-3xl p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:border-emerald-100 transition-all duration-300 overflow-hidden">
                <div class="relative z-10 flex items-start gap-6">
                    <div
                        class="p-4 rounded-2xl bg-emerald-50 text-emerald-600 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Statistik Beban Kerja</h3>
                        <p class="text-gray-500 text-sm leading-relaxed mb-6">Visualisasi distribusi tugas. Pantau apakah
                            algoritma Round Robin berjalan merata.</p>
                        <span
                            class="inline-flex items-center text-sm font-bold text-emerald-600 group-hover:translate-x-2 transition-transform">
                            Lihat Visualisasi Data <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </span>
                    </div>
                </div>
                <div
                    class="absolute -right-4 -bottom-4 w-24 h-24 bg-emerald-50/50 rounded-full blur-2xl group-hover:bg-emerald-100 transition-colors">
                </div>
            </a>
        </div>

        <div class="bg-gray-900 rounded-[2rem] p-8 md:p-12 text-white shadow-2xl relative overflow-hidden">
            <div class="relative z-10">
                <div class="mb-10 text-center md:text-left">
                    <h3 class="text-2xl font-black mb-2 tracking-tight">Export Laporan Tahunan/Bulanan</h3>
                    <p class="text-gray-400 max-w-xl font-medium">Siapkan dokumen fisik atau digital dalam format PDF atau
                        Excel untuk keperluan pelaporan resmi.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <div class="bg-white/5 backdrop-blur-md rounded-2xl p-6 border border-white/10">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-red-500/20 text-red-400 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9v-2h2v2zm0-4H9V7h2v5z" />
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold italic tracking-wide">Document PDF</h4>
                        </div>
                        <form action="{{ route('admin.laporan.pdf') }}" method="GET" class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label
                                        class="text-[10px] font-black uppercase tracking-widest text-gray-500 ml-1">Bulan</label>
                                    <select name="bulan"
                                        class="w-full bg-white/10 border-none rounded-xl text-sm focus:ring-2 focus:ring-red-500 transition-all font-bold">
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" class="text-gray-900"
                                                {{ date('n') == $i ? 'selected' : '' }}>
                                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label
                                        class="text-[10px] font-black uppercase tracking-widest text-gray-500 ml-1">Tahun</label>
                                    <select name="tahun"
                                        class="w-full bg-white/10 border-none rounded-xl text-sm focus:ring-2 focus:ring-red-500 transition-all font-bold">
                                        @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                                            <option value="{{ $i }}" class="text-gray-900">{{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <button type="submit"
                                class="w-full py-3.5 bg-red-500 hover:bg-red-600 text-white rounded-xl font-black text-sm transition-all shadow-lg shadow-red-500/20 transform hover:-translate-y-1">
                                GENERATE PDF
                            </button>
                        </form>
                    </div>

                    <div class="bg-white/5 backdrop-blur-md rounded-2xl p-6 border border-white/10">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-10 h-10 bg-emerald-500/20 text-emerald-400 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" />
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold italic tracking-wide">Spreadsheet Excel</h4>
                        </div>
                        <form action="{{ route('admin.laporan.excel') }}" method="GET" class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label
                                        class="text-[10px] font-black uppercase tracking-widest text-gray-500 ml-1">Bulan</label>
                                    <select name="bulan"
                                        class="w-full bg-white/10 border-none rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 transition-all font-bold">
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" class="text-gray-900"
                                                {{ date('n') == $i ? 'selected' : '' }}>
                                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label
                                        class="text-[10px] font-black uppercase tracking-widest text-gray-500 ml-1">Tahun</label>
                                    <select name="tahun"
                                        class="w-full bg-white/10 border-none rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 transition-all font-bold">
                                        @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                                            <option value="{{ $i }}" class="text-gray-900">
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <button type="submit"
                                class="w-full py-3.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-black text-sm transition-all shadow-lg shadow-emerald-500/20 transform hover:-translate-y-1">
                                GENERATE EXCEL
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="absolute -top-24 -left-24 w-64 h-64 bg-indigo-500/10 rounded-full blur-[100px]"></div>
            <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-emerald-500/10 rounded-full blur-[100px]"></div>
        </div>
    </div>
@endsection
