@extends('layouts.app')

@section('title', 'Penjadwalan & Assignment')
@section('header_title', 'Manajemen Penjadwalan')

@section('content')
    <div class="space-y-8 animate-in fade-in duration-500">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Penjadwalan & Assignment</h1>
                <p class="text-sm text-gray-500 flex items-center mt-1">
                    <span class="flex h-2 w-2 rounded-full bg-indigo-500 mr-2"></span>
                    Sistem optimasi penugasan berbasis Round Robin Algorithm
                </p>
            </div>
            <div class="flex items-center gap-3">
                <form action="{{ route('admin.penjadwalan.reset-queue') }}" method="POST">
                    @csrf
                    <button type="submit" onclick="return confirm('Reset antrean?')"
                        class="group inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-all shadow-sm">
                        <svg class="w-4 h-4 group-hover:rotate-180 transition-transform duration-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                        Reset Queue
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $statConfig = [
                    ['total_pegawai', 'Total Pegawai', 'blue', 'M17 20h5v-2a3 3 0 00-5.356-1.857...'],
                    ['pegawai_available', 'Tersedia', 'green', 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0...'],
                    ['tugas_pending', 'Pending', 'yellow', 'M12 8v4l3 3m6-3a9 9 0 11-18 0...'],
                    ['avg_beban', 'Rata-rata Beban', 'purple', 'M9 19v-6a2 2 0 00-2-2H5a2...'],
                ];
            @endphp

            @foreach ([['label' => 'Total Pegawai', 'val' => $stats['total_pegawai'], 'color' => 'blue', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'], ['label' => 'Tersedia', 'val' => $stats['pegawai_available'], 'color' => 'green', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'], ['label' => 'Tugas Pending', 'val' => $stats['tugas_pending'], 'color' => 'amber', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'], ['label' => 'Rata Beban', 'val' => number_format($stats['avg_beban'], 1) . '%', 'color' => 'indigo', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z']] as $item)
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="p-2.5 bg-{{ $item['color'] }}-50 rounded-xl text-{{ $item['color'] }}-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $item['icon'] }}"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-gray-900">{{ $item['val'] }}</span>
                    </div>
                    <p class="mt-4 text-sm font-medium text-gray-500 uppercase tracking-wider">{{ $item['label'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div class="xl:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4">
                    <form method="GET" action="{{ route('admin.penjadwalan.index') }}"
                        class="flex flex-wrap items-center gap-4">

                        <div class="flex-1 min-w-[200px]">
                            <label
                                class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 ml-1">Pilih
                                Bulan</label>
                            <div class="relative group">
                                <select name="bulan"
                                    class="w-full appearance-none bg-white border border-gray-200 rounded-2xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:ring-4 focus:ring-blue-50 focus:border-blue-400 transition-all cursor-pointer shadow-sm">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                        </option>
                                    @endfor
                                </select>
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-blue-500 transition-transform group-focus-within:rotate-180"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="flex-1 min-w-[200px]">
                            <label
                                class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 ml-1">Seksi
                                / Bagian</label>
                            <div class="relative group">
                                <select name="seksi"
                                    class="w-full appearance-none bg-white border border-gray-200 rounded-2xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:ring-4 focus:ring-blue-50 focus:border-blue-400 transition-all cursor-pointer shadow-sm">
                                    <option value="">Semua Bagian</option>
                                    @foreach ($seksiList as $s)
                                        <option value="{{ $s }}" {{ $seksi == $s ? 'selected' : '' }}>
                                            {{ $s }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-blue-500 transition-transform group-focus-within:rotate-180"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-end h-full pt-5">
                            <button type="submit"
                                class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-2xl transition-all shadow-lg shadow-blue-100 active:scale-95">
                                Terapkan Filter
                            </button>
                        </div>
                    </form>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($pegawai->sortBy('persentase_beban') as $p)
                        <div
                            class="bg-white rounded-2xl border border-gray-200 p-5 hover:border-indigo-300 transition-all group">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($p->name) }}&background=EEF2FF&color=4F46E5&bold=true"
                                            class="w-12 h-12 rounded-2xl shadow-sm">
                                        <div
                                            class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white {{ $p->canReceiveTask() ? 'bg-green-500' : 'bg-red-500' }}">
                                        </div>
                                    </div>
                                    <div>
                                        <h4
                                            class="text-sm font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">
                                            {{ $p->name }}</h4>
                                        <p class="text-xs text-gray-500 font-medium uppercase tracking-tighter">
                                            {{ $p->seksi }}</p>
                                    </div>
                                </div>
                                <button
                                    onclick="openSettingsModal({{ $p->id }}, '{{ $p->name }}', {{ $p->max_tugas_mingguan }}, {{ $p->max_tugas_bulanan }})"
                                    class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                                        </path>
                                    </svg>
                                </button>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <div
                                        class="flex justify-between text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1.5">
                                        <span>Beban Kerja</span>
                                        <span
                                            class="{{ $p->persentase_beban > 80 ? 'text-red-500' : 'text-indigo-600' }}">{{ $p->tugas_bulan_ini }}
                                            / {{ $p->max_tugas_bulanan }}</span>
                                    </div>
                                    <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-700 {{ $p->persentase_beban >= 90 ? 'bg-red-500' : ($p->persentase_beban >= 70 ? 'bg-amber-500' : 'bg-indigo-500') }}"
                                            style="width: {{ min($p->persentase_beban, 100) }}%"></div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between pt-2 border-t border-gray-50">
                                    {{-- <span class="text-xs text-gray-500 italic">Terakhir ditugaskan: 2 jam lalu</span> --}}
                                    <span class="text-xs font-bold text-gray-700">{{ $p->jam_bulan_ini }} Jam</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-gray-900 rounded-3xl p-6 text-white shadow-xl shadow-indigo-100 relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="text-lg font-bold mb-1">Antrean Otomatis</h3>
                        <p class="text-xs text-indigo-300 mb-6 font-medium">Prioritas penugasan berikutnya</p>

                        <div class="space-y-3">
                            @foreach ($queueStats->take(5) as $queue)
                                <div
                                    class="flex items-center gap-3 p-3 bg-white/10 rounded-2xl backdrop-blur-md border border-white/5 group hover:bg-white/20 transition-all">
                                    <span
                                        class="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-lg bg-indigo-500 text-[10px] font-black italic">#{{ $loop->iteration }}</span>
                                    <span
                                        class="flex-1 text-sm font-medium truncate">{{ $queue->user->name ?? 'N/A' }}</span>
                                    <div
                                        class="w-2 h-2 rounded-full {{ $queue->user && $queue->user->canReceiveTask() ? 'bg-green-400' : 'bg-red-400' }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-indigo-500/20 rounded-full blur-3xl"></div>
                </div>

                <div class="bg-white rounded-3xl border border-gray-200 shadow-sm flex flex-col h-[500px]">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="font-bold text-gray-900">Pilih Tugas</h3>
                        <p class="text-xs text-gray-500 mt-1">Checklist tugas yang ingin di-assign</p>
                    </div>

                    <form action="{{ route('admin.penjadwalan.run') }}" method="POST"
                        class="flex-1 flex flex-col overflow-hidden">
                        @csrf
                        <div class="flex-1 overflow-y-auto p-4 space-y-3 custom-scrollbar">
                            @forelse($tugasPending as $tugas)
                                <label class="block relative group cursor-pointer">
                                    <input type="checkbox" name="tugas_ids[]" value="{{ $tugas->id }}"
                                        class="peer hidden">
                                    <div
                                        class="p-4 rounded-2xl border border-gray-100 bg-gray-50 peer-checked:bg-indigo-50 peer-checked:border-indigo-200 transition-all">
                                        <div class="flex justify-between items-start mb-2">
                                            <span
                                                class="text-[10px] font-bold px-2 py-0.5 rounded-md uppercase {{ $tugas->prioritas == 'tinggi' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' }}">
                                                {{ $tugas->prioritas }}
                                            </span>
                                            <div
                                                class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:bg-indigo-600 peer-checked:border-indigo-600">
                                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="text-sm font-bold text-gray-800 line-clamp-1">{{ $tugas->nama_tugas }}
                                        </p>
                                        <div class="flex items-center gap-3 mt-2 text-[10px] font-bold text-gray-400">
                                            <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg> {{ $tugas->tanggal->format('d M') }}</span>
                                            <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg> {{ $tugas->durasi }} Jam</span>
                                        </div>
                                    </div>
                                </label>
                            @empty
                                <div class="text-center py-10">
                                    <p class="text-sm text-gray-400">Semua tugas sudah dijadwalkan ✨</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="p-6 bg-gray-50/50 border-t border-gray-100">
                            <button type="submit"
                                class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 transition-all transform hover:-translate-y-1 active:translate-y-0 disabled:opacity-50"
                                {{ $tugasPending->isEmpty() ? 'disabled' : '' }}>
                                Jalankan Assignment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="settingsModal" class="hidden fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeSettingsModal()">
            </div>
            <div class="relative bg-white rounded-3xl shadow-2xl max-w-sm w-full p-8 transform transition-all">
                <div class="text-center mb-6">
                    <div
                        class="mx-auto w-16 h-16 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-black text-gray-900" id="modalPegawaiName"></h3>
                    <p class="text-sm text-gray-500 font-medium mt-1">Sesuaikan batas beban kerja</p>
                </div>

                <form action="{{ route('admin.penjadwalan.update-settings') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="user_id" id="modalUserId">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Max Tugas /
                            Minggu</label>
                        <input type="number" name="max_tugas_mingguan" id="modalMaxMingguan"
                            class="w-full px-5 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-gray-700">
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Max Tugas /
                            Bulan</label>
                        <input type="number" name="max_tugas_bulanan" id="modalMaxBulanan"
                            class="w-full px-5 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-gray-700">
                    </div>
                    <div class="flex flex-col gap-2 pt-4">
                        <button type="submit"
                            class="w-full py-4 bg-gray-900 text-white rounded-2xl font-bold hover:bg-indigo-600 transition-all">Simpan
                            Perubahan</button>
                        <button type="button" onclick="closeSettingsModal()"
                            class="w-full py-4 bg-transparent text-gray-400 font-bold hover:text-gray-600 transition-all">Batalkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
