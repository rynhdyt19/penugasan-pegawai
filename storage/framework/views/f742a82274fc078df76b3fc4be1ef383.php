<!-- Notification Dropdown Component - Clean Version -->
<div x-data="notificationDropdown()" @click.away="open = false" class="relative">
    <button @click="toggleDropdown"
        class="relative w-10 h-10 flex items-center justify-center bg-gray-50 text-gray-400 hover:text-indigo-600 rounded-xl hover:bg-indigo-50 transition-all">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <span x-show="unreadCount > 0" x-text="unreadCount > 99 ? '99+' : unreadCount"
            class="absolute -top-1 -right-1 min-w-[18px] h-[18px] bg-red-500 text-white text-[10px] font-black rounded-full flex items-center justify-center px-1 border-2 border-white">
        </span>
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-3 w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50"
        style="display: none;">

        <!-- Header -->
        <div class="p-4 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-black text-gray-900">Notifikasi</h3>
                <div class="flex items-center gap-2">
                    <button @click="markAllAsRead" x-show="unreadCount > 0"
                        class="text-xs font-bold text-indigo-600 hover:text-indigo-700">
                        Tandai Semua Dibaca
                    </button>
                    <?php
                        $notifRoute =
                            Auth::user()->role === 'admin'
                                ? 'admin.notifications.index'
                                : 'pegawai.notifications.index';
                    ?>
                    <a href="<?php echo e(route($notifRoute)); ?>" class="text-xs font-bold text-gray-500 hover:text-gray-700">
                        Lihat Semua
                    </a>
                </div>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="max-h-96 overflow-y-auto custom-scrollbar">
            <template x-if="notifications.length === 0">
                <div class="p-8 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <p class="text-sm font-bold text-gray-400">Tidak ada notifikasi</p>
                </div>
            </template>

            <template x-for="notification in notifications" :key="notification.id">
                <div @click="handleNotificationClick(notification)"
                    x-bind:class="!notification.is_read ? 'bg-indigo-50' : ''"
                    class="p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition-all">
                    <div class="flex gap-3">
                        <!-- Icon -->
                        <div class="flex-shrink-0">
                            <div x-bind:class="getIconBg(notification.type)"
                                class="w-10 h-10 rounded-xl flex items-center justify-center">
                                <svg x-bind:class="getIconColor(notification.type)" class="w-5 h-5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path x-show="notification.type === 'success'" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    <path x-show="notification.type === 'warning'" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    <path x-show="notification.type === 'danger'" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    <path x-show="notification.type === 'info'" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <h4 class="text-sm font-bold text-gray-900"
                                    x-bind:class="!notification.is_read ? 'font-black' : ''"
                                    x-text="notification.title">
                                </h4>
                                <span x-show="!notification.is_read"
                                    class="flex-shrink-0 w-2 h-2 bg-indigo-600 rounded-full mt-1">
                                </span>
                            </div>
                            <p class="text-xs text-gray-600 mt-1 line-clamp-2" x-text="notification.message"></p>
                            <p class="text-xs text-gray-400 mt-2" x-text="formatTime(notification.created_at)"></p>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Footer -->
        <div class="p-3 border-t border-gray-100 bg-gray-50 rounded-b-2xl">
            <a href="<?php echo e(route($notifRoute)); ?>"
                class="block text-center text-xs font-bold text-indigo-600 hover:text-indigo-700">
                Lihat Semua Notifikasi
            </a>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
    <script>
        function notificationDropdown() {
            return {
                open: false,
                notifications: [],
                unreadCount: 0,

                init() {
                    this.fetchNotifications();
                    setInterval(() => {
                        this.fetchNotifications();
                    }, 30000);
                },

                toggleDropdown() {
                    this.open = !this.open;
                    if (this.open) {
                        this.fetchNotifications();
                    }
                },

                async fetchNotifications() {
                    try {
                        const response = await fetch('/notifications/fetch', {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        if (response.ok) {
                            const data = await response.json();
                            this.notifications = data.notifications;
                            this.unreadCount = data.unread_count;
                        }
                    } catch (error) {
                        console.error('Error fetching notifications:', error);
                    }
                },

                async handleNotificationClick(notification) {
                    if (!notification.is_read) {
                        await this.markAsRead(notification.id);
                    }

                    if (notification.url) {
                        window.location.href = notification.url;
                    }
                },

                async markAsRead(id) {
                    try {
                        const response = await fetch('/notifications/' + id + '/read', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        if (response.ok) {
                            this.fetchNotifications();
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    }
                },

                async markAllAsRead() {
                    console.log('Fungsi markAllAsRead dipicu'); // Untuk debug

                    // 1. Validasi awal: jika sudah nol, jangan lakukan apa-apa
                    if (this.unreadCount === 0) return;

                    // 2. Simpan backup untuk rollback jika gagal
                    const backupNotifications = [...this.notifications];
                    const backupCount = this.unreadCount;

                    // 3. UI Optimistic Update: Langsung kosongkan tampilan
                    this.notifications = [];
                    this.unreadCount = 0;

                    try {
                        const response = await fetch('/notifications/mark-all-read', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        const result = await response.json();
                        console.log('Respon Server:', result);

                        if (response.ok && result.success) {
                            // Berhasil: Tetap kosongkan (karena Controller fetch() sudah kita filter hanya is_read=false)
                            console.log('Berhasil menandai semua dibaca');

                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Berhasil diperbarui',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        } else {
                            throw new Error('Gagal di sisi server');
                        }
                    } catch (error) {
                        console.error('Error Detail:', error);
                        // Rollback: kembalikan data jika gagal koneksi/server error
                        this.notifications = backupNotifications;
                        this.unreadCount = backupCount;

                        alert('Gagal memperbarui notifikasi. Silakan coba lagi.');
                    }
                },

                getIconBg(type) {
                    const colors = {
                        'success': 'bg-green-50',
                        'warning': 'bg-yellow-50',
                        'danger': 'bg-red-50',
                        'info': 'bg-blue-50'
                    };
                    return colors[type] || colors.info;
                },

                getIconColor(type) {
                    const colors = {
                        'success': 'text-green-500',
                        'warning': 'text-yellow-500',
                        'danger': 'text-red-500',
                        'info': 'text-blue-500'
                    };
                    return colors[type] || colors.info;
                },

                formatTime(datetime) {
                    const date = new Date(datetime);
                    const now = new Date();
                    const diff = Math.floor((now - date) / 1000);

                    if (diff < 60) return 'Baru saja';
                    if (diff < 3600) return Math.floor(diff / 60) + ' menit yang lalu';
                    if (diff < 86400) return Math.floor(diff / 3600) + ' jam yang lalu';
                    if (diff < 604800) return Math.floor(diff / 86400) + ' hari yang lalu';

                    return date.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'short',
                        year: date.getFullYear() !== now.getFullYear() ? 'numeric' : undefined
                    });
                }
            }
        }
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\penugasan-pegawai\resources\views/components/notification-dropdown.blade.php ENDPATH**/ ?>