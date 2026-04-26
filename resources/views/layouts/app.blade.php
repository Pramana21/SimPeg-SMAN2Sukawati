<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name') }}</title>
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
    $canAccessAdministrasi = auth()->check() && (
        auth()->user()->can('administrasi_umum.view')
        || auth()->user()->can('administrasi_umum_pegawai.view')
        || auth()->user()->can('administrasi_umum_siswa.view')
    );
    $administrasiLandingRoute = auth()->check() && auth()->user()->can('administrasi_umum.view')
        ? route('administrasi.index')
        : route('administrasi.siswa.index');
    $isTamu = auth()->user()?->hasRole('Tamu');
@endphp

<div class="flex min-h-screen bg-gray-100">
    <!-- SIDEBAR -->
    <aside class="fixed inset-y-0 left-0 z-30 overflow-y-auto border-r bg-white sidebar-scroll" style="width: 260px;">
        <div class="flex min-h-full flex-col p-5">
            <div class="flex-1">
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

        @can('dashboard.view')
        <a href="/dashboard"
           class="{{ $menuBaseClass }} {{ request()->routeIs('dashboard*') || request()->is('dashboard*') ? $menuActiveClass : $menuInactiveClass }} mb-3">
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.75 4.75h6.5v6.5h-6.5zm8 0h6.5v6.5h-6.5zm-8 8h6.5v6.5h-6.5zm8 0h6.5v6.5h-6.5z"/>
            </svg>
            <span>Dashboard</span>
        </a>
        @endcan

        @if(auth()->user()?->hasRole('Super Admin') || auth()->user()?->hasRole('Admin Kepegawaian'))
            <!-- MANAJEMEN SISTEM -->
            <p class="text-gray-400 text-xs mt-6 mb-2">Manajemen Sistem</p>

            <div class="space-y-2 text-gray-700">

                @can('role_akses.view')
                <a href="{{ url('/roles') }}"
                    class="{{ $menuBaseClass }} {{ request()->routeIs('roles.*') || request()->is('roles*') ? $menuActiveClass : $menuInactiveClass }}">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3.75l6.75 2.5v5.1c0 4.25-2.73 8.22-6.75 9.9-4.02-1.68-6.75-5.65-6.75-9.9v-5.1z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.75 12l1.5 1.5 3-3"/>
                        </svg>
                        <span>Role Akses</span>
                </a>
                @endcan

                @can('manajemen_user.view')
                <a href="{{ route('users.index') }}"
                    class="{{ $menuBaseClass }} {{ request()->routeIs('users.*') || request()->routeIs('user.*') ? $menuActiveClass : $menuInactiveClass }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16.25 20.25v-1.5a3.75 3.75 0 0 0-3.75-3.75h-3A3.75 3.75 0 0 0 5.75 18.75v1.5"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 11.25a3.25 3.25 0 1 0 0-6.5 3.25 3.25 0 0 0 0 6.5zm8 9v-1a3.25 3.25 0 0 0-2.44-3.15m-1.06-10.1a3.25 3.25 0 0 1 0 6.3"/>
                    </svg>
                    <span>Manajemen User</span>
                </a>
                @endcan

                @can('audit_log.view')
                <a href="{{ url('/audit-log') }}"
                    class="{{ $menuBaseClass }} {{ request()->routeIs('audit.*') || request()->is('audit-log*') ? $menuActiveClass : $menuInactiveClass }}">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.75 12a7.25 7.25 0 1 0 2.12-5.13"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.75 5.75v4.5h4.5"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8.5v4l2.75 1.75"/>
                        </svg>
                        <span>Audit Log</span>
                </a>
                @endcan

            </div>
        @endif

        <!-- MANAJEMEN KEPEGAWAIAN -->
        <p class="text-gray-400 text-xs mt-6 mb-2">Manajemen Kepegawaian</p>

        <div class="space-y-2 text-gray-700">

            <!-- Penyuratan --> 
            @can('penyuratan.view')
            <a href="{{ url('/penyuratan') }}"
                class="{{ $menuBaseClass }} {{ request()->routeIs('penyuratan.*') || request()->is('penyuratan*') ? $menuActiveClass : $menuInactiveClass }}">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 3.75h6.25L19 8.5v11.75H8A2.25 2.25 0 0 1 5.75 18V6A2.25 2.25 0 0 1 8 3.75z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 3.75V8.5h4.75M9.5 12h5m-5 3h5"/>
                </svg>
                <span>Penyuratan</span>
            </a>
            @endcan

            <!-- Keuangan -->
            @can('keuangan.view')
            <div x-data="{ open: {{ request()->routeIs('keuangan.*') || request()->is('keuangan*') ? 'true' : 'false' }} }">

                <div class="flex items-center gap-2">
                    <a href="{{ route('keuangan.index') }}"
                        class="flex-1 {{ $menuBaseClass }} {{ request()->routeIs('keuangan.*') || request()->is('keuangan*') ? $menuActiveClass : $menuInactiveClass }}">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3.75v16.5M15.5 7.25a3.5 3.5 0 0 0-3.5-1.5c-1.93 0-3.5 1.23-3.5 2.75s1.57 2.75 3.5 2.75 3.5 1.23 3.5 2.75-1.57 2.75-3.5 2.75a3.9 3.9 0 0 1-3.75-1.75"/>
                        </svg>
                        <span>Keuangan</span>
                    </a>

                    <button type="button" @click="open = !open"
                        class="flex h-10 w-10 items-center justify-center rounded-lg transition {{ request()->routeIs('keuangan.*') || request()->is('keuangan*') ? 'text-blue-600 hover:bg-blue-50' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}"
                        :aria-expanded="open.toString()"
                        aria-controls="submenu-keuangan">
                        <svg class="h-5 w-5 shrink-0 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" :class="{ 'rotate-180': open }">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m6.75 9.75 5.25 5.25 5.25-5.25"/>
                        </svg>
                    </button>
                </div>

                <div x-show="open" id="submenu-keuangan" class="ml-6 mt-2 flex flex-col gap-1">
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
            @endcan

            <!-- Inventaris -->
            @can('inventaris.view')
            <a href="/inventaris"
                class="{{ $menuBaseClass }} {{ request()->routeIs('inventaris.*') || request()->is('inventaris*') ? $menuActiveClass : $menuInactiveClass }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m12 3.75 7 3.5-7 3.5-7-3.5zm7 3.5v9.5l-7 3.5-7-3.5v-9.5m7 3.5v9.5"/>
                    </svg>
                    <span>Inventaris</span>
            </a>
            @endcan

            <!-- Data Center -->
            @can('data_center.view')
            <a href="{{ route('data-center.index') }}"
                class="{{ $menuBaseClass }} {{ request()->routeIs('data-center.*') || request()->is('data-center*') ? $menuActiveClass : $menuInactiveClass }}">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <ellipse cx="12" cy="6.5" rx="6.25" ry="2.75" stroke-width="1.8"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5.75 6.5v5c0 1.52 2.8 2.75 6.25 2.75s6.25-1.23 6.25-2.75v-5m-12.5 5v5c0 1.52 2.8 2.75 6.25 2.75s6.25-1.23 6.25-2.75v-5"/>
                </svg>
                <span>Data Center</span>
            </a>
            @endcan

            <!-- Administrasi Umum -->
            @if($canAccessAdministrasi)
            <div x-data="{ open: {{ request()->routeIs('administrasi.*') || request()->is('administrasi*') ? 'true' : 'false' }} }">

                <div class="flex items-center gap-2">
                    <a href="{{ $administrasiLandingRoute }}"
                       class="flex-1 {{ $menuBaseClass }} {{ request()->routeIs('administrasi.*') || request()->is('administrasi*') ? $menuActiveClass : $menuInactiveClass }}">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <rect x="4.75" y="4.75" width="14.5" height="14.5" rx="2.25" stroke-width="1.8"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m8.75 12 2.25 2.25 4.25-4.5"/>
                        </svg>
                        <span>Administrasi Umum</span>
                    </a>

                    <button type="button" @click="open = !open"
                        class="flex h-10 w-10 items-center justify-center rounded-lg transition {{ request()->routeIs('administrasi.*') || request()->is('administrasi*') ? 'text-blue-600 hover:bg-blue-50' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}"
                        :aria-expanded="open.toString()"
                        aria-controls="submenu-administrasi">
                        <svg class="h-5 w-5 shrink-0 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" :class="{ 'rotate-180': open }">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m6.75 9.75 5.25 5.25 5.25-5.25"/>
                        </svg>
                    </button>
                </div>

                <div x-show="open" id="submenu-administrasi" class="ml-6 mt-2 flex flex-col gap-1">
                    @can('administrasi_umum_pegawai.view')
                    <a href="{{ route('administrasi.pegawai.index') }}"
                    class="{{ $submenuBaseClass }} {{ request()->routeIs('administrasi.pegawai.*') ? $submenuActiveClass : $submenuInactiveClass }}">
                        Pegawai
                    </a>
                    @endcan

                    @can('administrasi_umum_siswa.view')
                    <a href="{{ route('administrasi.siswa.index') }}"
                    class="{{ $submenuBaseClass }} {{ request()->routeIs('administrasi.siswa.*') ? $submenuActiveClass : $submenuInactiveClass }}">
                        Siswa
                    </a>
                    @endcan

                </div>

            </div>
            @endif

            </div>

            <!-- LOGOUT -->
            <div class="mt-16 border-t pt-4">

                <p class="text-gray-400 text-xs mb-2">Account</p>

                <form method="POST" action="{{ route('logout') }}">
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
    </aside>

    <div class="shrink-0" style="width: 260px;"></div>

    <!-- MAIN -->
    <main class="min-w-0 flex-1 overflow-visible">

        <!-- NAVBAR -->
        <div class="relative z-40 overflow-visible flex items-center justify-between border-b bg-white px-6 py-4">

            <h1 class="text-xl font-semibold">Welcome Back</h1>

            <div class="flex items-center gap-3">

                @if(auth()->user()?->hasRole('Super Admin') || auth()->user()?->hasRole('Admin Kepegawaian'))
                <form action="{{ route('search') }}" method="POST" class="relative">
                    @csrf
                    <input type="text"
                        name="q"
                        value="{{ old('q') }}"
                        placeholder="Search..."
                        required
                        class="w-80 rounded bg-blue-500 py-2 pl-10 pr-4 text-white placeholder-white outline-none">
                    <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="11" cy="11" r="7"></circle>
                            <path stroke-linecap="round" stroke-linejoin="round" d="m20 20-3.5-3.5"></path>
                        </svg>
                    </span>
                </form>
                @endif

                <div class="flex items-center gap-3">
                    <div class="relative z-50" id="notifWrapper">
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

                    <aside id="notifPanel"
                        class="fixed z-[1000] hidden w-[350px] max-w-[calc(100vw-2rem)] overflow-hidden rounded-xl border border-slate-200 bg-white shadow-2xl ring-1 ring-black/5 transition-all duration-200 ease-out"
                        aria-hidden="true">
                        <div class="border-b px-5 py-4">
                            <h2 class="text-lg font-semibold text-gray-900">Notifikasi</h2>
                            <p class="mt-1 text-sm text-gray-500">Aktivitas terbaru dari Audit Log</p>
                        </div>

                        <div class="space-y-3 overflow-y-auto bg-white p-4" style="max-height: min(32rem, calc(100vh - 6rem));">
                            @forelse(($notifications ?? collect()) as $notif)
                                @php
                                    $activityColor = match($notif->aktivitas) {
                                        'Tambah Data' => 'text-emerald-600',
                                        'Update Data' => 'text-blue-600',
                                        'Hapus Data' => 'text-rose-600',
                                        default => 'text-slate-600',
                                    };

                                    $notifUser = $notif->user->username ?? $notif->nama_pengguna ?? 'System';
                                @endphp

                                <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm transition hover:shadow-md">
                                    <div class="mb-1 text-xs font-semibold uppercase tracking-wide {{ $activityColor }}">
                                        {{ strtoupper($notif->modul ?? 'Aktivitas') }} - {{ strtoupper($notif->aktivitas ?? 'Update') }}
                                    </div>
                                    <div class="mb-2 text-sm leading-relaxed text-gray-700">
                                        {{ $notif->keterangan ?: 'Aktivitas tanpa keterangan.' }}
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-gray-400">
                                        <span>{{ $notifUser }}</span>
                                        <span>&bull;</span>
                                        <span>{{ $notif->created_at ? $notif->created_at->diffForHumans() : '-' }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-xl border border-dashed border-gray-200 bg-gray-50 p-4 text-sm text-gray-500 shadow">
                                    Tidak ada notifikasi
                                </div>
                            @endforelse
                        </div>
                    </aside>
                    </div>

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
        <div class="relative z-0 overflow-visible p-6">
            @if(session('error'))
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-600">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>

    </main>
</div>

<style>
    .sidebar-scroll {
        scrollbar-width: thin;
    }
</style>

<script>
    const notifWrapper = document.getElementById('notifWrapper');
    const notifBtn = document.getElementById('notifButton');
    const notifPanel = document.getElementById('notifPanel');
    const notifIndicator = document.getElementById('notifIndicator');
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    let hasMarkedNotificationRead = false;

    if (notifWrapper && notifBtn && notifPanel) {
        const positionNotifPanel = () => {
            const buttonRect = notifBtn.getBoundingClientRect();
            const panelWidth = Math.min(350, window.innerWidth - 32);
            const top = buttonRect.bottom + 12;
            const left = Math.min(
                Math.max(16, buttonRect.right - panelWidth),
                window.innerWidth - panelWidth - 16
            );

            notifPanel.style.top = `${top}px`;
            notifPanel.style.left = `${left}px`;
            notifPanel.style.right = 'auto';
        };

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

        const isNotifOpen = () => !notifPanel.classList.contains('hidden');

        const openNotifPanel = () => {
            positionNotifPanel();
            notifPanel.classList.remove('hidden', 'opacity-0', '-translate-y-2');
            notifPanel.classList.add('opacity-100', 'translate-y-0');
            notifBtn.setAttribute('aria-expanded', 'true');
            notifPanel.setAttribute('aria-hidden', 'false');
            markNotificationsAsRead();
        };

        const closeNotifPanel = () => {
            notifPanel.classList.add('opacity-0', '-translate-y-2');
            notifPanel.classList.remove('opacity-100', 'translate-y-0');
            window.setTimeout(() => {
                if (notifBtn.getAttribute('aria-expanded') === 'false') {
                    notifPanel.classList.add('hidden');
                }
            }, 200);
            notifBtn.setAttribute('aria-expanded', 'false');
            notifPanel.setAttribute('aria-hidden', 'true');
        };

        notifBtn.addEventListener('click', (event) => {
            event.stopPropagation();

            if (!isNotifOpen()) {
                openNotifPanel();
                return;
            }

            closeNotifPanel();
        });

        notifPanel.addEventListener('click', (event) => {
            event.stopPropagation();
        });

        document.addEventListener('click', (event) => {
            if (!notifWrapper.contains(event.target)) {
                closeNotifPanel();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeNotifPanel();
            }
        });

        window.addEventListener('resize', () => {
            if (isNotifOpen()) {
                positionNotifPanel();
            }
        });

        window.addEventListener('scroll', () => {
            if (isNotifOpen()) {
                positionNotifPanel();
            }
        }, true);

        notifPanel.classList.add('opacity-0', '-translate-y-2');
    }
</script>
</body>
</html>
