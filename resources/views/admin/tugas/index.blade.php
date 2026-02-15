@extends('layouts.app')

@section('title', 'Data Tugas')

@section('content')
    <div class="px-4 sm:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Data Tugas</h2>
            <a href="{{ route('admin.tugas.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Tugas
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 border-collapse">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-4 border-b border-r border-gray-200 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Nama Tugas</th>
                            <th
                                class="px-6 py-4 border-b border-r border-gray-200 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Tanggal</th>
                            <th
                                class="px-6 py-4 border-b border-r border-gray-200 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Lokasi</th>
                            <th
                                class="px-6 py-4 border-b border-r border-gray-200 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Durasi</th>
                            <th
                                class="px-6 py-4 border-b border-r border-gray-200 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Prioritas</th>
                            <th
                                class="px-6 py-4 border-b border-r border-gray-200 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-6 py-4 border-b border-r border-gray-200 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Ditugaskan Ke</th>

                            <th
                                class="px-6 py-4 border-b text-xs border-gray-200 font-bold text-gray-600 uppercase tracking-wider text-center w-28">
                                AKSI
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tugas as $t)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 border-r border-gray-200 whitespace-nowrap text-sm font-medium text-gray-900"
                                    title="{{ $t->nama_tugas }}">
                                    {{ Str::limit($t->nama_tugas, 25, '...') }}
                                </td>
                                <td class="px-6 py-4 border-r border-gray-200 whitespace-nowrap text-sm text-gray-600">
                                    {{ $t->tanggal->format('d M Y') }}</td>
                                <td class="px-6 py-4 border-r border-gray-200 whitespace-nowrap text-sm text-gray-600">
                                    {{ $t->lokasi }}</td>
                                <td class="px-6 py-4 border-r border-gray-200 whitespace-nowrap text-sm text-gray-600">
                                    {{ $t->durasi }} jam</td>
                                <td class="px-6 py-4 border-r border-gray-200 whitespace-nowrap">
                                    <span
                                        class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full {{ $t->prioritas_color }}">
                                        {{ ucfirst($t->prioritas) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 border-r border-gray-200 whitespace-nowrap">
                                    <span
                                        class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-md {{ $t->status_color }}">
                                        {{ ucfirst($t->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 border-r border-gray-200 whitespace-nowrap text-sm text-gray-600">
                                    @if ($t->penugasan->first())
                                        <div class="flex items-center">
                                            <div
                                                class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-500 mr-2">
                                                {{ substr($t->penugasan->first()->user->name, 0, 1) }}
                                            </div>
                                            {{ $t->penugasan->first()->user->name }}
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic">Belum ditugaskan</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- Tombol Detail --}}
                                        <a href="{{ route('admin.tugas.show', $t) }}"
                                            class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors group"
                                            title="Detail">
                                            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>

                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('admin.tugas.edit', $t) }}"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors group"
                                            title="Edit">
                                            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('admin.tugas.destroy', $t) }}" method="POST" class="inline"
                                            id="delete-form-{{ $t->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete('{{ $t->id }}')"
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors group"
                                                title="Hapus">
                                                <svg class="w-5 h-5 transition-transform group-hover:scale-110"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $tugas->links() }}
        </div>
    </div>
@endsection
