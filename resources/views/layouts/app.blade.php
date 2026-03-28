<!DOCTYPE html>
<html>
<head>
    <title>SIMPEG</title>

    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <script src="//unpkg.com/alpinejs" defer></script>

</head>

<body class="bg-gray-100">

<div class="flex">

    <!-- SIDEBAR -->
    <div class="w-64 bg-white min-h-screen p-5 border-r flex flex-col justify-between">

        <!-- LOGO -->
        <div class="flex items-center gap-3 mb-6">

            <!-- GANTI LINK LOGO DI SINI -->
            <img src="{{ asset('logo.png') }}" class="w-10 h-10 rounded-full">

            <span class="font-semibold text-sm">SMAN 2 Sukawati</span>

        </div>

        <!-- NAVIGATION -->
        <p class="text-gray-400 text-xs mb-2">Navigation</p>

        <a href="/dashboard"
           class="flex items-center gap-3 p-2 rounded bg-blue-500 text-white mb-3">

            <i data-feather="grid"></i>
            Dashboard

        </a>

        <!-- MANAJEMEN SISTEM -->
        <p class="text-gray-400 text-xs mt-6 mb-2">Manajemen Sistem</p>

        <div class="space-y-2 text-gray-700">

            <a href="{{ url('/roles') }}"
                class="{{ request()->is('roles*') ? 'bg-blue-500 text-white' : '' }} p-2 flex items-center gap-2 rounded">

                    <i data-feather="shield"></i>
                    Role Akses
            </a>

            <a class="flex gap-3 items-center p-2">
                <i data-feather="users"></i> Manajemen User
            </a>

            <a href="{{ url('/audit-log') }}"
                class="{{ request()->is('audit-log') ? 'bg-blue-500 text-white' : '' }} p-2 flex items-center gap-2 rounded">

                    <i data-feather="rotate-ccw"></i>
                    Audit Log

            </a>

        </div>

        <!-- MANAJEMEN KEPEGAWAIAN -->
        <p class="text-gray-400 text-xs mt-6 mb-2">Manajemen Kepegawaian</p>

        <div class="space-y-2 text-gray-700">

            <!-- Penyuratan --> 
            <a href="{{ url('/penyuratan') }}"
                class="{{ request()->is('penyuratan*') ? 'bg-blue-500 text-white' : '' }} p-2 flex items-center gap-2 rounded">

                <i data-feather="file-text"></i>
                Penyuratan
            </a>

            <!-- Keuangan -->
            <a href="{{ route('keuangan.index') }}"
                class="flex gap-3 items-center p-2 rounded
                {{ request()->is('keuangan*') ? 'bg-blue-500 text-white' : '' }}">

                <i data-feather="dollar-sign"></i>
                Keuangan
            </a>

            <div class="ml-6 mt-2 flex flex-col gap-1">

                <a href="{{ route('keuangan.kategori', 'laporan') }}"
                    class="text-sm px-3 py-1 rounded hover:bg-blue-100
                    {{ request()->is('keuangan/laporan*') ? 'text-blue-500 font-semibold' : '' }}">
                    Laporan Keuangan
                </a>

                <a href="{{ route('keuangan.kategori', 'gaji-asn') }}"
                    class="text-sm px-3 py-1 rounded hover:bg-blue-100
                    {{ request()->is('keuangan/gaji-asn*') ? 'text-blue-500 font-semibold' : '' }}">
                    Gaji ASN
                </a>

                <a href="{{ route('keuangan.kategori', 'tpp-asn') }}"
                    class="text-sm px-3 py-1 rounded hover:bg-blue-100
                    {{ request()->is('keuangan/tpp-asn*') ? 'text-blue-500 font-semibold' : '' }}">
                    TPP ASN
                </a>

                <a href="{{ route('keuangan.kategori', 'tpg-guru') }}"
                    class="text-sm px-3 py-1 rounded hover:bg-blue-100
                    {{ request()->is('keuangan/tpg-guru*') ? 'text-blue-500 font-semibold' : '' }}">
                    TPG Guru
                </a>

            </div>

            <!-- Inventaris -->
            <a href="/inventaris"
                class="flex items-center gap-2 px-4 py-2 rounded-md
                {{ request()->is('inventaris*') ? 'bg-blue-500 text-white' : 'text-gray-600' }}">
                    
                    <i data-feather="box"></i>
                    Inventaris
            </a>

            <!-- Data Center -->
            <a href="{{ route('data-center.index') }}"
                class="flex gap-3 items-center p-2 rounded
                {{ request()->is('data-center*') ? 'bg-blue-500 text-white' : '' }}">

                <i data-feather="database"></i>
                Data Center

            </a>

            <!-- Administrasi Umum -->
            <div x-data="{ open: false }">

                <button @click="open = !open"
                    class="flex items-center justify-between w-full px-4 py-2 rounded-lg hover:bg-blue-100">

                    <div class="flex items-center gap-2">
                        <i data-feather="check-square"></i>
                        <span>Administrasi Umum</span>
                    </div>

                    <i data-feather="chevron-down"></i>
                </button>

                <!-- SUB MENU -->
                <div x-show="open" class="ml-6 mt-2 flex flex-col gap-1">

                    <!-- Pegawai -->
                    <a href="/administrasi?kategori=Pegawai"
                    class="px-3 py-1 text-sm hover:bg-blue-100 rounded">
                        Pegawai
                    </a>

                    <!-- Siswa -->
                    <a href="/administrasi?kategori=Siswa"
                    class="px-3 py-1 text-sm hover:bg-blue-100 rounded">
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
                    class="flex items-center gap-3 text-gray-500 hover:text-red-500 p-2">
                    <i data-feather="log-out"></i>
                    log out
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

<!-- AKTIFKAN ICON -->
<script>
    feather.replace()
</script>

</body>
</html>