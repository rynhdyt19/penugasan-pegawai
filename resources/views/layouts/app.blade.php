<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Penjadwalan Pegawai') | BPS</title>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('gambar/favicon.ico') }}">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .sidebar-link {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .sidebar-link:hover {
            background-color: #f8faff;
            color: #4f46e5;
            transform: translateX(4px);
        }

        .sidebar-link.active {
            background: linear-gradient(to right, #eef2ff, #ffffff);
            color: #4f46e5;
            font-weight: 800;
        }

        .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: -12px;
            top: 20%;
            height: 60%;
            width: 6px;
            background-color: #4f46e5;
            border-radius: 0 4px 4px 0;
            box-shadow: 2px 0 12px rgba(79, 70, 229, 0.4);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 10px;
        }

        .glass-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>

<body class="bg-[#FBFBFE] antialiased text-gray-900">
    <div class="flex h-screen overflow-hidden" x-data="{ mobileSidebar: false }">

        <aside :class="mobileSidebar ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-gray-100 flex flex-col transition-transform duration-300 lg:relative lg:translate-x-0">

            <div class="h-20 flex items-center px-8 mb-4">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200">
                        <img src="{{ asset('gambar/bps_logo.png') }}" class="h-6 w-auto brightness-0 invert"
                            alt="Logo">
                    </div>
                    <div class="flex flex-col">
                        <span class="text-lg font-black tracking-tighter text-gray-900 leading-none">PENUGASAN</span>
                        <span class="text-[10px] font-bold text-gray-400 tracking-[0.2em] uppercase">Badan Pusat
                            Statistik</span>
                    </div>
                </div>
            </div>

            <div class="px-6 mb-6">
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-4 h-4 text-gray-300 group-focus-within:text-indigo-500 transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" placeholder="Cari fitur..."
                        class="w-full pl-10 pr-4 py-3 text-xs font-bold border-none rounded-2xl bg-gray-50 focus:ring-2 focus:ring-indigo-500/10 transition-all outline-none placeholder:text-gray-300">
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto custom-scrollbar px-6 space-y-1">
                <p class="px-3 mb-3 text-[10px] font-black text-gray-300 uppercase tracking-[0.3em]">Menu Utama</p>

                @if (Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                        class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-gray-500' }} flex items-center space-x-3 px-4 py-3.5 rounded-2xl text-sm font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.pegawai.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.pegawai.*') ? 'active' : 'text-gray-500' }} flex items-center space-x-3 px-4 py-3.5 rounded-2xl text-sm font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Database Pegawai</span>
                    </a>
                    <a href="{{ route('admin.tugas.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.tugas.*') ? 'active' : 'text-gray-500' }} flex items-center space-x-3 px-4 py-3.5 rounded-2xl text-sm font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        <span>Master Tugas</span>
                    </a>
                    <a href="{{ route('admin.penjadwalan.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.penjadwalan.*') ? 'active' : 'text-gray-500' }} flex items-center space-x-3 px-4 py-3.5 rounded-2xl text-sm font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Penjadwalan</span>
                    </a>
                @else
                    <a href="{{ route('pegawai.dashboard') }}"
                        class="sidebar-link {{ request()->routeIs('pegawai.dashboard') ? 'active' : 'text-gray-500' }} flex items-center space-x-3 px-4 py-3.5 rounded-2xl text-sm font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('pegawai.jadwal') }}"
                        class="sidebar-link {{ request()->routeIs('pegawai.jadwal*') ? 'active' : 'text-gray-500' }} flex items-center space-x-3 px-4 py-3.5 rounded-2xl text-sm font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Jadwal Saya</span>
                    </a>

                    <a href="{{ route('pegawai.riwayat') }}"
                        class="sidebar-link {{ request()->routeIs('pegawai.riwayat*') ? 'active' : 'text-gray-500' }} flex items-center space-x-3 px-4 py-3.5 rounded-2xl text-sm font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Riwayat Tugas</span>
                    </a>
                @endif

                <p class="px-3 mt-10 mb-3 text-[10px] font-black text-gray-300 uppercase tracking-[0.3em]">Sistem</p>

                <a href="{{ Auth::user()->isAdmin() ? route('admin.settings.index') : route('pegawai.settings.index') }}"
                    class="sidebar-link text-gray-500 flex items-center space-x-3 px-4 py-3.5 rounded-2xl text-sm font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Pengaturan</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="mt-4 pt-4 border-t border-gray-50">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center space-x-3 px-4 py-3.5 rounded-2xl text-sm font-black text-red-400 hover:bg-red-50 transition-all group">
                        <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </nav>

            <div class="p-6">
                <div class="flex items-center gap-3 p-3 bg-indigo-900 rounded-[1.5rem] shadow-xl shadow-indigo-200">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=fff&color=4F46E5"
                        class="w-10 h-10 rounded-xl shadow-sm">
                    <div class="flex flex-col overflow-hidden">
                        <p class="text-[11px] font-black text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[9px] font-bold text-indigo-300 uppercase tracking-widest">
                            {{ Auth::user()->role }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            <header
                class="h-20 glass-header border-b border-gray-100 flex items-center justify-between px-8 z-40 sticky top-0">
                <div class="flex items-center gap-4">
                    <button @click="mobileSidebar = true"
                        class="lg:hidden p-2.5 bg-gray-50 text-gray-500 rounded-xl hover:bg-gray-100 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="flex flex-col">
                        <h2 class="text-sm font-black text-gray-900 uppercase tracking-[0.15em]">@yield('header_title', 'Ringkasan')</h2>
                        <span class="text-[10px] font-bold text-gray-400">Pusat Data Terpadu BPS</span>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Notification Dropdown -->
                    @include('components.notification-dropdown')

                    <div class="h-6 w-[1px] bg-gray-200"></div>

                    <div class="flex items-center gap-3 pl-2">
                        <p class="text-[11px] font-black text-gray-400 text-right hidden sm:block">
                            WITA <br>
                            <span class="text-gray-900">
                                {{ \Carbon\Carbon::now('Asia/Makassar')->format('H:i') }}
                            </span>
                        </p>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto custom-scrollbar bg-[#FBFBFE]">
                <div class="p-8 max-w-[1600px] mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>

        <div x-show="mobileSidebar" @click="mobileSidebar = false"
            class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-40 lg:hidden" x-transition:opacity></div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data tugas ini akan dihapus permanen dari sistem!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4F46E5',
                cancelButtonColor: '#EF4444',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-3xl shadow-2xl border border-gray-100',
                    confirmButton: 'px-6 py-2.5 rounded-xl font-bold uppercase text-xs tracking-widest',
                    cancelButton: 'px-6 py-2.5 rounded-xl font-bold uppercase text-xs tracking-widest'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }

        @if (session('success'))
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif
    </script>
    @stack('scripts')

</body>

</html>
