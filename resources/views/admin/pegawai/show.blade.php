@extends('layouts.app')

@section('title', 'Detail Pegawai')

@section('content')
    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm font-medium">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.pegawai.index') }}"
                                class="text-gray-500 hover:text-indigo-600 transition-colors">Pegawai</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-gray-400 md:ml-2">Detail Profile</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Detail Pegawai</h2>
            </div>
            <a href="{{ route('admin.pegawai.index') }}"
                class="inline-flex items-center justify-center px-4 py-2 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-xl shadow-sm hover:bg-gray-50 hover:text-indigo-600 transition-all">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Kembali ke Daftar
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="h-32 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
                    <div class="px-6 pb-6">
                        <div class="relative flex justify-center">
                            <div class="absolute -top-12 p-1 bg-white rounded-2xl shadow-lg">
                                <div
                                    class="w-24 h-24 bg-gray-100 rounded-xl flex items-center justify-center text-indigo-600">
                                    <span class="text-3xl font-black">{{ strtoupper(substr($pegawai->name, 0, 2)) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-16 text-center">
                            <h3 class="text-xl font-bold text-gray-900">{{ $pegawai->name }}</h3>
                            <p class="text-sm font-medium text-indigo-600">{{ $pegawai->jabatan }}</p>
                            <div class="mt-4 flex flex-wrap justify-center gap-2">
                                <span
                                    class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full">{{ $pegawai->seksi }}</span>
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 text-xs font-bold rounded-full">NIP:
                                    {{ $pegawai->nip }}</span>
                            </div>
                        </div>
                        <div class="mt-8 space-y-4 border-t border-gray-50 pt-6">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                {{ $pegawai->email }}
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                                {{ $pegawai->kontak ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-indigo-900 rounded-3xl p-6 text-white shadow-xl">
                    <h4 class="text-sm font-black uppercase tracking-widest text-indigo-300 mb-4">Kuota Batas Tugas</h4>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span>Mingguan</span>
                                <span class="font-bold">{{ $pegawai->max_tugas_mingguan }} Tugas</span>
                            </div>
                            <div class="w-full bg-white/10 rounded-full h-1.5">
                                <div class="bg-indigo-400 h-1.5 rounded-full" style="width: 70%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span>Bulanan</span>
                                <span class="font-bold">{{ $pegawai->max_tugas_bulanan }} Tugas</span>
                            </div>
                            <div class="w-full bg-white/10 rounded-full h-1.5">
                                <div class="bg-purple-400 h-1.5 rounded-full" style="width: 50%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm text-center">
                        <p class="text-[10px] font-black uppercase tracking-wider text-gray-400 mb-1">Total</p>
                        <p class="text-2xl font-black text-indigo-600">{{ $statistik['total_tugas'] }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm text-center">
                        <p class="text-[10px] font-black uppercase tracking-wider text-gray-400 mb-1">Aktif</p>
                        <p class="text-2xl font-black text-amber-500">{{ $statistik['tugas_aktif'] }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm text-center">
                        <p class="text-[10px] font-black uppercase tracking-wider text-gray-400 mb-1">Selesai</p>
                        <p class="text-2xl font-black text-emerald-500">{{ $statistik['tugas_selesai'] }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm text-center">
                        <p class="text-[10px] font-black uppercase tracking-wider text-gray-400 mb-1">Jam Kerja</p>
                        <p class="text-2xl font-black text-purple-600">{{ $statistik['total_jam'] }}h</p>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center">
                        <h3 class="font-bold text-gray-900">Riwayat Penugasan Terakhir</h3>
                        <span class="text-xs font-medium text-gray-400">Total {{ count($pegawai->penugasan) }} entri</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">
                                        Nama Tugas</th>
                                    <th
                                        class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 text-center">
                                        Status</th>
                                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">
                                        Jadwal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($pegawai->penugasan as $p)
                                    <tr class="hover:bg-gray-50/50 transition-colors group">
                                        <td class="px-6 py-4">
                                            <p
                                                class="text-sm font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">
                                                {{ $p->tugas->nama_tugas }}</p>
                                            <p class="text-xs text-gray-400">{{ $p->tugas->lokasi }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="inline-flex px-3 py-1 text-[10px] font-black rounded-lg border {{ $p->tugas->status_color }}">
                                                {{ strtoupper($p->tugas->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-medium text-gray-700">
                                                {{ $p->tugas->tanggal->format('d M Y') }}</p>
                                            <p class="text-xs text-gray-400">{{ $p->tugas->durasi }} Jam Kerja</p>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center text-gray-400">
                                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                                </path>
                                            </svg>
                                            <p class="text-sm">Belum ada riwayat tugas untuk pegawai ini.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
