<!DOCTYPE html>
<html>
<head>
    <title>SIMPEG</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <script src="//unpkg.com/alpinejs" defer></script>

</head>

<body class="bg-gray-100">

@php
    $menuBaseClass = 'flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition';
    $menuActiveClass = 'bg-blue-500 text-white';
    $menuInactiveClass = 'text-gray-700 hover:bg-gray-100';
    $submenuBaseClass = 'block rounded-lg px-3 py-2 text-sm transition';
    $submenuActiveClass = 'bg-blue-50 font-semibold text-blue-600';
    $submenuInactiveClass = 'text-gray-600 hover:bg-gray-100 hover:text-gray-800';
@endphp

<div class="flex">

    <!-- SIDEBAR -->
    <div class="w-64 bg-white min-h-screen p-5 border-r flex flex-col justify-between">

        <!-- LOGO -->
        <div class="flex items-center gap-3 px-4 py-4 mb-2">
            <img src="{{ asset('images/logo.png') }}"
                 alt="Logo"
                 class="w-10 h-10 rounded-lg object-contain">

            <div class="flex flex-col leading-tight">
                <span class="font-semibold text-sm">SMAN 2 Sukawati</span>
            </div>
        </div>

        <!-- NAVIGATION -->
        <p class="text-gray-400 text-xs mb-2">Navigation</p>

        <a href="/dashboard"
           class="{{ $menuBaseClass }} {{ request()->routeIs('dashboard') ? $menuActiveClass : $menuInactiveClass }} mb-3">
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.75 4.75h6.5v6.5h-6.5zm8 0h6.5v6.5h-6.5zm-8 8h6.5v6.5h-6.5zm8 0h6.5v6.5h-6.5z"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- MANAJEMEN SISTEM -->
        <p class="text-gray-400 text-xs mt-6 mb-2">Manajemen Sistem</p>

        <div class="space-y-2 text-gray-700">

            <a href="{{ url('/roles') }}"
                class="{{ $menuBaseClass }} {{ request()->routeIs('roles.*') || request()->is('roles*') ? $menuActiveClass : $menuInactiveClass }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3.75l6.75 2.5v5.1c0 4.25-2.73 8.22-6.75 9.9-4.02-1.68-6.75-5.65-6.75-9.9v-5.1z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.75 12l1.5 1.5 3-3"/>
                    </svg>
                    <span>Role Akses</span>
            </a>

            <a href="{{ route('users.index') }}"
                class="{{ $menuBaseClass }} {{ request()->routeIs('users.*') || request()->routeIs('user.*') ? $menuActiveClass : $menuInactiveClass }}">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16.25 20.25v-1.5a3.75 3.75 0 0 0-3.75-3.75h-3A3.75 3.75 0 0 0 5.75 18.75v1.5"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 11.25a3.25 3.25 0 1 0 0-6.5 3.25 3.25 0 0 0 0 6.5zm8 9v-1a3.25 3.25 0 0 0-2.44-3.15m-1.06-10.1a3.25 3.25 0 0 1 0 6.3"/>
                </svg>
                <span>Manajemen User</span>
            </a>

            <a href="{{ url('/audit-log') }}"
                class="{{ $menuBaseClass }} {{ request()->routeIs('audit.*') || request()->is('audit-log*') ? $menuActiveClass : $menuInactiveClass }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.75 12a7.25 7.25 0 1 0 2.12-5.13"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.75 5.75v4.5h4.5"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8.5v4l2.75 1.75"/>
                    </svg>
                    <span>Audit Log</span>
            </a>

        </div>

        <!-- MANAJEMEN KEPEGAWAIAN -->
        <p class="text-gray-400 text-xs mt-6 mb-2">Manajemen Kepegawaian</p>

        <div class="space-y-2 text-gray-700">

            <!-- Penyuratan --> 
            <a href="{{ url('/penyuratan') }}"
                class="{{ $menuBaseClass }} {{ request()->routeIs('penyuratan.*') || request()->is('penyuratan*') ? $menuActiveClass : $menuInactiveClass }}">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 3.75h6.25L19 8.5v11.75H8A2.25 2.25 0 0 1 5.75 18V6A2.25 2.25 0 0 1 8 3.75z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 3.75V8.5h4.75M9.5 12h5m-5 3h5"/>
                </svg>
                <span>Penyuratan</span>
            </a>

            <!-- Keuangan -->
            <div x-data="{ open: {{ request()->routeIs('keuangan.*') || request()->is('keuangan*') ? 'true' : 'false' }} }">

                <button @click="open = !open"
                    class="w-full {{ $menuBaseClass }} justify-between {{ request()->routeIs('keuangan.*') || request()->is('keuangan*') ? $menuActiveClass : $menuInactiveClass }}">

                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3.75v16.5M15.5 7.25a3.5 3.5 0 0 0-3.5-1.5c-1.93 0-3.5 1.23-3.5 2.75s1.57 2.75 3.5 2.75 3.5 1.23 3.5 2.75-1.57 2.75-3.5 2.75a3.9 3.9 0 0 1-3.75-1.75"/>
                        </svg>
                        <span>Keuangan</span>
                    </div>

                    <svg class="h-5 w-5 shrink-0 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" :class="{ 'rotate-180': open }">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m6.75 9.75 5.25 5.25 5.25-5.25"/>
                    </svg>
                </button>

                <div x-show="open" class="ml-6 mt-2 flex flex-col gap-1">
                    <a href="{{ route('keuangan.index') }}"
                        class="{{ $submenuBaseClass }} {{ request()->routeIs('keuangan.index') ? $submenuActiveClass : $submenuInactiveClass }}">
                        Dashboard Keuangan
                    </a>

                    <a href="{{ route('keuangan.kategori', 'laporan') }}"
                        class="{{ $submenuBaseClass }} {{ request()->is('keuangan/laporan*') ? $submenuActiveClass : $submenuInactiveClass }}">
                        Laporan Keuangan
                    </a>

                    <a href="{{ route('keuangan.kategori', 'gaji-asn') }}"
                        class="{{ $submenuBaseClass }} {{ request()->is('keuangan/gaji-asn*') ? $submenuActiveClass : $submenuInactiveClass }}">
                        Gaji ASN
                    </a>

                    <a href="{{ route('keuangan.kategori', 'tpp-asn') }}"
                        class="{{ $submenuBaseClass }} {{ request()->is('keuangan/tpp-asn*') ? $submenuActiveClass : $submenuInactiveClass }}">
                        TPP ASN
                    </a>

                    <a href="{{ route('keuangan.kategori', 'tpg-guru') }}"
                        class="{{ $submenuBaseClass }} {{ request()->is('keuangan/tpg-guru*') ? $submenuActiveClass : $submenuInactiveClass }}">
                        TPG Guru
                    </a>
                </div>

            </div>

            <!-- Inventaris -->
            <a href="/inventaris"
                class="{{ $menuBaseClass }} {{ request()->routeIs('inventaris.*') || request()->is('inventaris*') ? $menuActiveClass : $menuInactiveClass }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m12 3.75 7 3.5-7 3.5-7-3.5zm7 3.5v9.5l-7 3.5-7-3.5v-9.5m7 3.5v9.5"/>
                    </svg>
                    <span>Inventaris</span>
            </a>

            <!-- Data Center -->
            <a href="{{ route('data-center.index') }}"
                class="{{ $menuBaseClass }} {{ request()->routeIs('data-center.*') || request()->is('data-center*') ? $menuActiveClass : $menuInactiveClass }}">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <ellipse cx="12" cy="6.5" rx="6.25" ry="2.75" stroke-width="1.8"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5.75 6.5v5c0 1.52 2.8 2.75 6.25 2.75s6.25-1.23 6.25-2.75v-5m-12.5 5v5c0 1.52 2.8 2.75 6.25 2.75s6.25-1.23 6.25-2.75v-5"/>
                </svg>
                <span>Data Center</span>
            </a>

            <!-- Administrasi Umum -->
            <div x-data="{ open: {{ request()->routeIs('administrasi.*') || request()->is('administrasi*') ? 'true' : 'false' }} }">

                <div class="{{ request()->routeIs('administrasi.*') || request()->is('administrasi*') ? $menuActiveClass : $menuInactiveClass }} flex items-center rounded-lg">
                    <a href="{{ route('administrasi.index') }}"
                       class="flex flex-1 items-center gap-3 px-4 py-2 text-sm font-medium">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <rect x="4.75" y="4.75" width="14.5" height="14.5" rx="2.25" stroke-width="1.8"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m8.75 12 2.25 2.25 4.25-4.5"/>
                        </svg>
                        <span>Administrasi Umum</span>
                    </a>

                    <button @click="open = !open"
                        class="px-3 py-2">
                        <svg class="h-5 w-5 shrink-0 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" :class="{ 'rotate-180': open }">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m6.75 9.75 5.25 5.25 5.25-5.25"/>
                        </svg>
                    </button>
                </div>

                <div x-show="open" class="ml-6 mt-2 flex flex-col gap-1">
                    <a href="{{ route('administrasi.pegawai.index') }}"
                    class="{{ $submenuBaseClass }} {{ request()->routeIs('administrasi.pegawai.*') ? $submenuActiveClass : $submenuInactiveClass }}">
                        Pegawai
                    </a>

                    <a href="{{ route('administrasi.siswa.index') }}"
                    class="{{ $submenuBaseClass }} {{ request()->routeIs('administrasi.siswa.*') ? $submenuActiveClass : $submenuInactiveClass }}">
                        Siswa
                    </a>

                </div>

            </div>

        </div>
         <!-- LOGOUT -->
        <div class="mt-16 border-t pt-4">

            <p class="text-gray-400 text-xs mb-2">Account</p>

            <form method="POST" action="/logout">
                @csrf
                <button type="submit"
                    class="flex items-center gap-3 rounded-lg px-4 py-2 text-gray-500 transition hover:bg-gray-100 hover:text-red-500">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.75 5.75H7.5A2.75 2.75 0 0 0 4.75 8.5v7A2.75 2.75 0 0 0 7.5 18.25h3.25"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 16.25 18.25 12 14 7.75M18 12H9"/>
                    </svg>
                    <span>log out</span>
                </button>
            </form>

        </div>

    </div>

    <!-- MAIN -->
    <div class="flex-1">

        <!-- NAVBAR -->
        <div class="flex items-center justify-between border-b bg-white px-6 py-4">

            <h1 class="text-xl font-semibold">Welcome Back</h1>

            <div class="flex items-center gap-3">

                <div class="relative">
                    <input type="text"
                        placeholder="Search..."
                        class="w-80 rounded bg-blue-500 py-2 pl-10 pr-4 text-white placeholder-white outline-none">
                    <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="11" cy="11" r="7"></circle>
                            <path stroke-linecap="round" stroke-linejoin="round" d="m20 20-3.5-3.5"></path>
                        </svg>
                    </span>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button"
                        id="notifButton"
                        class="relative flex h-10 w-10 items-center justify-center rounded-full bg-blue-500 transition-all duration-300 ease-in-out hover:bg-blue-600"
                        aria-label="Buka notifikasi"
                        aria-controls="notifPanel"
                        aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 0 0-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a3 3 0 006 0"/>
                        </svg>

                        <span id="notifIndicator"
                            class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-white {{ ($notifications ?? collect())->count() > 0 ? (($hasUnread ?? false) ? 'bg-red-500' : 'bg-green-500') : 'hidden' }}"></span>
                    </button>

                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 21a8 8 0 10-16 0"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                </div>

            </div>

        </div>

        <!-- CONTENT -->
        <div class="p-6">
            @yield('content')
        </div>

    </div>
   

</div>

<div id="notifOverlay" class="fixed inset-0 z-40 hidden bg-black bg-opacity-30 transition-all duration-300 ease-in-out"></div>

<aside id="notifPanel"
    class="fixed top-0 right-0 z-50 flex h-full w-80 max-w-full translate-x-full transform flex-col bg-white shadow-2xl transition-transform duration-300 ease-in-out"
    aria-hidden="true">
    <div class="border-b px-5 py-4">
        <h2 class="text-lg font-semibold text-gray-900">Notifikasi</h2>
        <p class="mt-1 text-sm text-gray-500">Aktivitas terbaru dari Audit Log</p>
    </div>

    <div class="flex-1 space-y-3 overflow-y-auto p-4">
        @forelse(($notifications ?? collect()) as $notif)
            <div class="rounded-xl border border-gray-100 bg-white p-4 shadow">
                <div class="border-b border-gray-200 pb-3 text-sm leading-relaxed text-gray-800">
                    {{ $notif->keterangan ?: 'Aktivitas tanpa keterangan.' }}
                </div>
                <div class="pt-2 text-xs text-gray-400">
                    {{ $notif->created_at ? $notif->created_at->timezone('Asia/Makassar')->format('d-m-Y H:i') : '-' }}
                </div>
            </div>
        @empty
            <div class="rounded-xl border border-dashed border-gray-200 bg-gray-50 p-4 text-sm text-gray-500 shadow">
                Tidak ada notifikasi
            </div>
        @endforelse
    </div>
</aside>

<script>
    const notifBtn = document.getElementById('notifButton');
    const notifPanel = document.getElementById('notifPanel');
    const notifOverlay = document.getElementById('notifOverlay');
    const notifIndicator = document.getElementById('notifIndicator');
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    let hasMarkedNotificationRead = false;

    if (notifBtn && notifPanel && notifOverlay) {
        const markNotificationsAsRead = async () => {
            if (hasMarkedNotificationRead || !notifIndicator || notifIndicator.classList.contains('hidden')) {
                return;
            }

            try {
                const response = await fetch('{{ route('notifications.read') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken ? csrfToken.getAttribute('content') : '',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({}),
                });

                if (!response.ok) {
                    return;
                }

                hasMarkedNotificationRead = true;
                notifIndicator.classList.remove('bg-red-500');
                notifIndicator.classList.add('bg-green-500');
            } catch (error) {
                console.error('Gagal menandai notifikasi sebagai dibaca.', error);
            }
        };

        const openNotifPanel = () => {
            notifPanel.classList.remove('translate-x-full');
            notifOverlay.classList.remove('hidden');
            notifBtn.setAttribute('aria-expanded', 'true');
            notifPanel.setAttribute('aria-hidden', 'false');
            markNotificationsAsRead();
        };

        const closeNotifPanel = () => {
            notifPanel.classList.add('translate-x-full');
            notifOverlay.classList.add('hidden');
            notifBtn.setAttribute('aria-expanded', 'false');
            notifPanel.setAttribute('aria-hidden', 'true');
        };

        notifBtn.addEventListener('click', () => {
            const isClosed = notifPanel.classList.contains('translate-x-full');

            if (isClosed) {
                openNotifPanel();
                return;
            }

            closeNotifPanel();
        });

        notifOverlay.addEventListener('click', closeNotifPanel);

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeNotifPanel();
            }
        });
    }
</script>
</body>
</html>
