<!DOCTYPE html>
<html>
<head>
    <title>SIMPEG</title>

    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

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

            <a class="flex gap-3 items-center p-2">
                <i data-feather="shield"></i> Role Akses
            </a>

            <a class="flex gap-3 items-center p-2">
                <i data-feather="users"></i> Manajemen User
            </a>

            <a class="flex gap-3 items-center p-2">
                <i data-feather="clock"></i> Audit Log
            </a>

        </div>

        <!-- MANAJEMEN KEPEGAWAIAN -->
        <p class="text-gray-400 text-xs mt-6 mb-2">Manajemen Kepegawaian</p>

        <div class="space-y-2 text-gray-700">

            <a class="flex gap-3 items-center p-2">
                <i data-feather="file-text"></i> Penyuratan
            </a>

            <a class="flex gap-3 items-center p-2">
                <i data-feather="dollar-sign"></i> Keuangan
            </a>

            <a class="flex gap-3 items-center p-2">
                <i data-feather="archive"></i> Inventaris
            </a>

            <a class="flex gap-3 items-center p-2">
                <i data-feather="database"></i> Data Center
            </a>

            <a class="flex gap-3 items-center p-2">
                <i data-feather="check-square"></i> Administrasi Umum
            </a>

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