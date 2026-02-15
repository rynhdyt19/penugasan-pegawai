@extends('layouts.app')

@section('title', 'Dashboard Pegawai')
@section('header_title', 'Ringkasan Kerja')

@section('content')
<div class="p-6 max-w-7xl mx-auto">
    <div class="mb-10">
        <h2 class="text-3xl font-black text-gray-900 tracking-tight">Dashboard</h2>
        <p class="text-sm font-medium text-gray-500 mt-1">
            Selamat bekerja kembali, <span class="text-indigo-600 font-bold">{{ Auth::user()->name }}</span>! 👋
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="group bg-blue-600 rounded-[2rem] p-6 text-white shadow-lg shadow-blue-200 hover:scale-[1.02] transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <span class="text-[10px] font-black text-blue-100 uppercase tracking-widest">Aktif</span>
            </div>
            <p class="text-xs font-bold text-blue-100 uppercase tracking-wider">Tugas Aktif</p>
            <p class="text-4xl font-black mt-1">{{ $tugasAktif }}</p>
        </div>

        <div class="group bg-emerald-500 rounded-[2rem] p-6 text-white shadow-lg shadow-emerald-200 hover:scale-[1.02] transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-[10px] font-black text-emerald-100 uppercase tracking-widest">Selesai</span>
            </div>
            <p class="text-xs font-bold text-emerald-100 uppercase tracking-wider">Total Selesai</p>
            <p class="text-4xl font-black mt-1">{{ $tugasSelesai }}</p>
        </div>

        <div class="group bg-indigo-600 rounded-[2rem] p-6 text-white shadow-lg shadow-indigo-200 hover:scale-[1.02] transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div class="text-right">
                    <span class="text-[9px] font-black text-indigo-100 uppercase tracking-widest block">Batas Mingguan</span>
                    <span class="text-[10px] font-bold text-indigo-200 italic">Maks {{ Auth::user()->max_tugas_mingguan }}</span>
                </div>
            </div>
            <p class="text-xs font-bold text-indigo-100 uppercase tracking-wider">Minggu Ini</p>
            <p class="text-4xl font-black mt-1">{{ $tugasMingguIni }}</p>
        </div>

        <div class="group bg-orange-500 rounded-[2rem] p-6 text-white shadow-lg shadow-orange-200 hover:scale-[1.02] transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="text-right">
                    <span class="text-[9px] font-black text-orange-100 uppercase tracking-widest block">Batas Bulanan</span>
                    <span class="text-[10px] font-bold text-orange-200 italic">Maks {{ Auth::user()->max_tugas_bulanan }}</span>
                </div>
            </div>
            <p class="text-xs font-bold text-orange-100 uppercase tracking-wider">Bulan Ini</p>
            <p class="text-4xl font-black mt-1">{{ $tugasBulanIni }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        <div class="bg-white rounded-[2.5rem] border border-gray-100 p-8 shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Beban Kerja Mingguan</h3>
                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-black rounded-lg uppercase">
                    Kapasitas {{ $bebanKerja['mingguan']['percentage'] }}%
                </span>
            </div>
            
            <div class="flex justify-between items-end mb-3">
                <span class="text-4xl font-black text-gray-900 tracking-tighter">{{ $bebanKerja['mingguan']['current'] }} <span class="text-lg text-gray-300 font-medium">/ {{ $bebanKerja['mingguan']['max'] }}</span></span>
                <span class="text-[11px] font-bold text-indigo-500 uppercase">Sisa {{ $bebanKerja['mingguan']['sisa'] }} Slot</span>
            </div>

            <div class="w-full bg-gray-50 rounded-2xl h-4 overflow-hidden p-1 border border-gray-100">
                <div class="h-full rounded-xl bg-indigo-600 transition-all duration-1000"
                     style="width: {{ min($bebanKerja['mingguan']['percentage'], 100) }}%"></div>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-gray-100 p-8 shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Beban Kerja Bulanan</h3>
                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-lg uppercase">
                    Kapasitas {{ $bebanKerja['bulanan']['percentage'] }}%
                </span>
            </div>
            
            <div class="flex justify-between items-end mb-3">
                <span class="text-4xl font-black text-gray-900 tracking-tighter">{{ $bebanKerja['bulanan']['current'] }} <span class="text-lg text-gray-300 font-medium">/ {{ $bebanKerja['bulanan']['max'] }}</span></span>
                <span class="text-[11px] font-bold text-emerald-500 uppercase">Sisa {{ $bebanKerja['bulanan']['sisa'] }} Slot</span>
            </div>

            <div class="w-full bg-gray-50 rounded-2xl h-4 overflow-hidden p-1 border border-gray-100">
                <div class="h-full rounded-xl bg-emerald-500 transition-all duration-1000"
                     style="width: {{ min($bebanKerja['bulanan']['percentage'], 100) }}%"></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
            <div>
                <h3 class="font-black text-gray-900 tracking-tight text-lg">Tugas Mendatang</h3>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Agenda 7 Hari ke Depan</p>
            </div>
            <a href="{{ route('pegawai.jadwal') }}" class="text-[10px] font-black text-indigo-600 border-2 border-indigo-100 px-5 py-2.5 rounded-xl hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all uppercase tracking-widest">
                Lihat Semua
            </a>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse ($tugasMendatang as $penugasan)
                    @php $tugas = $penugasan->tugas; @endphp
                    <div class="group relative flex items-center justify-between p-5 border border-gray-50 rounded-3xl hover:border-indigo-100 hover:bg-indigo-50/20 transition-all duration-300">
                        <div class="flex items-center gap-5">
                            <div class="w-14 h-14 bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center transition-transform group-hover:scale-105">
                                <span class="text-[9px] font-black text-indigo-500 uppercase leading-none mb-1">{{ $tugas->tanggal->translatedFormat('M') }}</span>
                                <span class="text-xl font-black text-gray-900 leading-none">{{ $tugas->tanggal->format('d') }}</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $tugas->nama_tugas }}</h4>
                                <div class="flex items-center gap-4 mt-2 text-[11px] font-bold text-gray-400">
                                    <span class="flex items-center gap-1.5">📍 {{ $tugas->lokasi }}</span>
                                    <span class="flex items-center gap-1.5 text-indigo-400">⏱️ {{ $tugas->durasi }} Jam</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col items-end">
                            <span class="px-2 py-1 text-[9px] font-black uppercase tracking-tighter rounded-md {{ $tugas->prioritas_color }} mb-2">
                                {{ $tugas->prioritas }}
                            </span>
                            <a href="{{ route('pegawai.tugas.detail', $tugas) }}" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:underline decoration-2 underline-offset-4 transition-all">
                                Detail →
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-12 bg-gray-50 rounded-[2rem] border-2 border-dashed border-gray-100">
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-widest italic">Belum ada tugas terjadwal</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection