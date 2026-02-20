@extends('layouts.app')

@section('title', 'Notifikasi')
@section('header_title', 'Notifikasi')

@section('content')
    <div class="space-y-6" x-data="notificationManager()">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center">
            <div>
                <h1 class="text-2xl font-black text-gray-900">Notifikasi</h1>
                <p class="text-sm text-gray-500 mt-1">
                    <span x-text="unreadCount"></span> notifikasi belum dibaca
                </p>
            </div>

            <div class="flex gap-2">
                <button @click="markAllAsRead"
                    class="px-4 py-2 bg-indigo-600 text-white text-xs font-bold rounded-xl hover:bg-indigo-700 transition-all">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Tandai Semua Dibaca
                </button>

                <button @click="deleteAllRead"
                    class="px-4 py-2 bg-red-600 text-white text-xs font-bold rounded-xl hover:bg-red-700 transition-all">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus Sudah Dibaca
                </button>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="bg-white rounded-2xl p-2 border border-gray-100">
            <div class="flex gap-2">
                <button @click="filter = 'all'"
                    :class="filter === 'all' ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-50'"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all">
                    Semua
                </button>
                <button @click="filter = 'unread'"
                    :class="filter === 'unread' ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-50'"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all">
                    Belum Dibaca
                </button>
                <button @click="filter = 'read'"
                    :class="filter === 'read' ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-50'"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all">
                    Sudah Dibaca
                </button>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="space-y-3">
            @forelse($notifications as $notification)
                <div x-show="shouldShow({{ $notification->is_read ? 'true' : 'false' }})"
                    class="bg-white rounded-2xl p-5 border border-gray-100 hover:shadow-lg transition-all group"
                    x-transition>
                    <div class="flex gap-4">
                        <!-- Icon -->
                        <div class="flex-shrink-0">
                            <div
                                class="w-12 h-12 rounded-xl {{ $notification->bg_class }} flex items-center justify-center">
                                @if ($notification->type === 'success')
                                    <svg class="w-6 h-6 {{ $notification->icon_class }}" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @elseif($notification->type === 'warning')
                                    <svg class="w-6 h-6 {{ $notification->icon_class }}" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                @elseif($notification->type === 'danger')
                                    <svg class="w-6 h-6 {{ $notification->icon_class }}" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 {{ $notification->icon_class }}" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1">
                                    <h3
                                        class="text-sm font-bold text-gray-900 {{ !$notification->is_read ? 'font-black' : '' }}">
                                        {{ $notification->title }}
                                        @if (!$notification->is_read)
                                            <span class="inline-block w-2 h-2 bg-indigo-600 rounded-full ml-2"></span>
                                        @endif
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
                                    <p class="text-xs text-gray-400 mt-2">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @if (!$notification->is_read)
                                        <button @click="markAsRead({{ $notification->id }})"
                                            class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all"
                                            title="Tandai sudah dibaca">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                    @endif

                                    @if ($notification->url)
                                        <a href="{{ $notification->url }}"
                                            class="p-2 text-gray-600 hover:bg-gray-50 rounded-lg transition-all"
                                            title="Lihat detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    @endif

                                    <button @click="deleteNotification({{ $notification->id }})"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl p-12 text-center border border-gray-100">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Tidak Ada Notifikasi</h3>
                    <p class="text-sm text-gray-500">Anda belum memiliki notifikasi</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($notifications->hasPages())
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>

    <script>
        function notificationManager() {
            return {
                filter: 'all',
                unreadCount: {{ $unreadCount }},

                shouldShow(isRead) {
                    if (this.filter === 'all') return true;
                    if (this.filter === 'unread') return !isRead;
                    if (this.filter === 'read') return isRead;
                    return true;
                },

                async markAsRead(id) {
                    try {
                        const response = await fetch(`/notifications/${id}/read`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            }
                        });

                        if (response.ok) {
                            window.location.reload();
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    }
                },

                async markAllAsRead() {
                    if (this.unreadCount === 0) {
                        Swal.fire('Info', 'Tidak ada notifikasi yang belum dibaca', 'info');
                        return;
                    }

                    const result = await Swal.fire({
                        title: 'Tandai Semua Dibaca?',
                        text: 'Semua notifikasi akan ditandai sebagai sudah dibaca',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#4F46E5',
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: 'Ya, Tandai',
                        cancelButtonText: 'Batal'
                    });

                    if (result.isConfirmed) {
                        try {
                            const response = await fetch('/notifications/mark-all-read', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                }
                            });

                            if (response.ok) {
                                window.location.reload();
                            }
                        } catch (error) {
                            console.error('Error:', error);
                        }
                    }
                },

                async deleteNotification(id) {
                    const result = await Swal.fire({
                        title: 'Hapus Notifikasi?',
                        text: 'Notifikasi ini akan dihapus permanen',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#EF4444',
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal'
                    });

                    if (result.isConfirmed) {
                        try {
                            const response = await fetch(`/notifications/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                }
                            });

                            if (response.ok) {
                                window.location.reload();
                            }
                        } catch (error) {
                            console.error('Error:', error);
                        }
                    }
                },

                async deleteAllRead() {
                    const result = await Swal.fire({
                        title: 'Hapus Semua yang Sudah Dibaca?',
                        text: 'Semua notifikasi yang sudah dibaca akan dihapus',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#EF4444',
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal'
                    });

                    if (result.isConfirmed) {
                        try {
                            const response = await fetch('/notifications/delete-all-read', {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                }
                            });

                            if (response.ok) {
                                window.location.reload();
                            }
                        } catch (error) {
                            console.error('Error:', error);
                        }
                    }
                }
            }
        }
    </script>
@endsection
