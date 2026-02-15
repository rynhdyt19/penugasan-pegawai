@extends('layouts.app')

@section('title', 'Detail Tugas')

@section('content')
    <div class="space-y-6 animate-in fade-in duration-500">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-100 pb-6">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span
                        class="px-2 py-0.5 bg-gray-100 text-gray-500 text-[10px] font-black uppercase tracking-widest rounded">ID
                        #{{ $tugas->id }}</span>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Detail Tugas</h2>
                </div>
                <p class="text-gray-500">Pantau progres dan rincian penugasan secara mendalam.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.tugas.edit', $tugas) }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-bold text-indigo-600 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                        </path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.tugas.index') }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-bold text-gray-500 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                            <h3 class="text-xl font-black text-gray-900 italic tracking-tight uppercase">Rincian Pekerjaan
                            </h3>
                            <div class="flex gap-2">
                                <span
                                    class="px-4 py-1.5 text-[10px] font-black rounded-full border {{ $tugas->prioritas_color }}">
                                    {{ strtoupper($tugas->prioritas) }}
                                </span>
                                <span
                                    class="px-4 py-1.5 text-[10px] font-black rounded-full border {{ $tugas->status_color }}">
                                    {{ strtoupper($tugas->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                            <div class="space-y-1">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400">Nama
                                    Tugas</label>
                                <p class="text-xl font-bold text-gray-900 leading-tight">{{ $tugas->nama_tugas }}</p>
                            </div>

                            <div class="space-y-1">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400">Lokasi</label>
                                <p class="text-lg font-bold text-indigo-600 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-indigo-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                    </svg>
                                    {{ $tugas->lokasi }}
                                </p>
                            </div>

                            <div class="flex gap-8">
                                <div class="space-y-1">
                                    <label
                                        class="text-[10px] font-black uppercase tracking-widest text-gray-400">Tanggal</label>
                                    <p class="text-base font-bold text-gray-800">{{ $tugas->tanggal->format('d M Y') }}</p>
                                </div>
                                <div class="space-y-1 border-l border-gray-100 pl-8">
                                    <label
                                        class="text-[10px] font-black uppercase tracking-widest text-gray-400">Estimasi</label>
                                    <p class="text-base font-bold text-gray-800">{{ $tugas->durasi }} Jam Kerja</p>
                                </div>
                            </div>

                            @if ($tugas->keterangan)
                                <div
                                    class="md:col-span-2 space-y-1 mt-4 p-4 bg-gray-50 rounded-2xl border-l-4 border-indigo-500">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400">Instruksi
                                        Tambahan</label>
                                    <p class="text-sm text-gray-600 leading-relaxed">{{ $tugas->keterangan }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-gray-900 rounded-[2rem] p-8 text-white shadow-2xl relative overflow-hidden h-full">
                    <h3 class="text-lg font-black uppercase tracking-widest text-indigo-400 mb-8 relative z-10 italic">
                        Pelaksana Tugas</h3>

                    <div class="relative z-10">
                        @if ($tugas->penugasan->first())
                            @php $penugasan = $tugas->penugasan->first(); @endphp
                            <div class="space-y-8">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-14 h-14 bg-indigo-500/20 rounded-2xl flex items-center justify-center border border-indigo-500/30">
                                        <span
                                            class="text-xl font-black text-indigo-400">{{ strtoupper(substr($penugasan->user->name, 0, 2)) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-xl font-bold leading-none">{{ $penugasan->user->name }}</p>
                                        <p class="text-xs font-medium text-gray-400 mt-1 italic tracking-wide">
                                            {{ $penugasan->user->nip }}</p>
                                    </div>
                                </div>

                                <div class="space-y-4 pt-6 border-t border-white/5 text-sm">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-500 font-bold uppercase tracking-tighter text-[10px]">Bidang
                                            / Seksi</span>
                                        <span class="font-bold text-indigo-300">{{ $penugasan->user->seksi }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-500 font-bold uppercase tracking-tighter text-[10px]">Assign
                                            Time</span>
                                        <span class="font-bold">{{ $penugasan->assigned_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    @if ($penugasan->completed_at)
                                        <div
                                            class="flex justify-between items-center p-3 bg-emerald-500/10 rounded-xl border border-emerald-500/20">
                                            <span
                                                class="text-emerald-400 font-black uppercase tracking-tighter text-[10px]">Selesai
                                                Pada</span>
                                            <span
                                                class="font-black text-emerald-400">{{ $penugasan->completed_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                    @endif
                                </div>

                                @if ($penugasan->catatan)
                                    <div class="mt-6 p-4 bg-white/5 rounded-2xl border border-white/10">
                                        <p class="text-[10px] font-black text-indigo-400 uppercase mb-2">Catatan Eksekusi:
                                        </p>
                                        <p class="text-sm text-gray-300 italic">"{{ $penugasan->catatan }}"</p>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-12 flex flex-col items-center">
                                <div
                                    class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mb-4 animate-pulse">
                                    <svg class="h-10 w-10 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                </div>
                                <p class="text-gray-400 font-bold text-sm">Belum Ada Pelaksana</p>

                                @if ($tugas->status === 'pending')
                                    <form action="{{ route('admin.tugas.assign', $tugas) }}" method="POST"
                                        class="mt-8 w-full">
                                        @csrf
                                        <button type="submit"
                                            class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-black py-4 rounded-2xl text-[11px] tracking-widest transition-all shadow-xl shadow-indigo-600/20 transform hover:-translate-y-1 uppercase">
                                            Tugaskan Otomatis (Round Robin)
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-indigo-500/20 rounded-full blur-3xl"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
