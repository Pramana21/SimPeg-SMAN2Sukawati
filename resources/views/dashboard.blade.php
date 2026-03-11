@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">
Dashboard SIMPEG
</h1>

<div class="grid grid-cols-3 gap-6">

<div class="bg-white shadow p-4 rounded">

<h2 class="text-lg font-bold">
Total Pegawai
</h2>

<p class="text-3xl mt-2">
{{ $totalPegawai }}
</p>

</div>

<div class="bg-white shadow p-4 rounded">

<h2 class="text-lg font-bold">
Total Dokumen
</h2>

<p class="text-3xl mt-2">
{{ $totalDokumen }}
</p>

</div>

<div class="bg-white shadow p-4 rounded">

<h2 class="text-lg font-bold">
Total Inventaris
</h2>

<p class="text-3xl mt-2">
{{ $totalInventaris }}
</p>

</div>

</div>

@endsection