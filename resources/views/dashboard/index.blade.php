@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">

Dashboard SIMPEG

</h1>

<div class="grid grid-cols-3 gap-6">

<div class="bg-white shadow rounded-lg p-6 text-center">

<h2 class="text-lg font-semibold">Total Pegawai</h2>

<p class="text-3xl font-bold mt-2">

{{ $totalPegawai }}

</p>

</div>


<div class="bg-white shadow rounded-lg p-6 text-center">

<h2 class="text-lg font-semibold">Total Dokumen</h2>

<p class="text-3xl font-bold mt-2">

{{ $totalDokumen }}

</p>

</div>


<div class="bg-white shadow rounded-lg p-6 text-center">

<h2 class="text-lg font-semibold">Total Inventaris</h2>

<p class="text-3xl font-bold mt-2">

{{ $totalInventaris }}

</p>

</div>

</div>

@endsection