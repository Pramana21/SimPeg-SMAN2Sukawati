@extends('layouts.app')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">
            {{ $kategori->nama_kategori }}
        </h1>

        <a href="{{ route('keuangan.create', $kategori->slug) }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
            + Tambah
        </a>
    </div>

    {{-- FILTER --}}
    <div class="flex gap-3 mb-4">
        <select class="bg-blue-500 text-white px-4 py-2 rounded-lg">
            <option>Januari</option>
        </select>

        <select class="bg-blue-500 text-white px-4 py-2 rounded-lg">
            <option>2025</option>
        </select>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-xl shadow p-4">
        <h2 class="text-lg font-semibold mb-4">Dokumen</h2>

        @include('admin.keuangan.partials.table')
    </div>

</div>

@endsection