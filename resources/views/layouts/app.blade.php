<!DOCTYPE html>
<html>
<head>
    <title>SIMPEG</title>

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
        <div class="bg-white px-6 py-4 flex justify-between items-center border-b">

            <h1 class="text-xl font-semibold">Welcome Back</h1>

            <div class="flex items-center gap-4">

                <!-- SEARCH -->
                <input type="text"
                    placeholder="Search..."
                    class="bg-blue-500 text-white placeholder-white px-4 py-2 rounded w-80">

                <!-- ICON -->
                <div class="w-10 h-10 bg-blue-500 rounded-full"></div>
                <div class="w-10 h-10 bg-blue-500 rounded-full"></div>

                <!-- PROFILE -->
                <div class="w-10 h-10 bg-gray-300 rounded-full"></div>

            </div>

        </div>

        <!-- CONTENT -->
        <div class="p-6">
            @yield('content')
        </div>

    </div>
   

</div>
</body>
</html>
