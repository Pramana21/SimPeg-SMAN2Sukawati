<!DOCTYPE html>
<html>
<head>
<title>SIMPEG</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

</head>

<body class="bg-gray-100">

<div class="flex">

<!-- SIDEBAR -->

<div class="w-64 bg-blue-900 text-white min-h-screen p-5">

<h2 class="text-xl font-bold mb-6">SIMPEG</h2>

<ul>

<li class="mb-3">
<a href="/dashboard">Dashboard</a>
</li>

<li class="mb-3">
<a href="/pegawai">Pegawai</a>
</li>

<li class="mb-3">
<a href="#">Inventaris</a>
</li>

<li class="mb-3">
<a href="#">Dokumen</a>
</li>

</ul>

</div>

<!-- MAIN CONTENT -->

<div class="flex-1">

@include('components.navbar')

<div class="p-6">

@yield('content')

</div>

</div>

</div>

</body>
</html>