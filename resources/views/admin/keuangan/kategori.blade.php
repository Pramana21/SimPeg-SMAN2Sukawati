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

    {{-- 🔥 FILTER REAL --}}
    <form method="GET" class="flex gap-3 mb-4">

        <select name="bulan" class="bg-blue-500 text-white px-4 py-2 rounded-lg">
            <option value="">Semua Bulan</option>
            @foreach(range(1,12) as $b)
                <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>
                    {{ date('F', mktime(0,0,0,$b,1)) }}
                </option>
            @endforeach
        </select>

        <select name="tahun" class="bg-blue-500 text-white px-4 py-2 rounded-lg">
            <option value="">Semua Tahun</option>
            @foreach(range(date('Y'), 2020) as $t)
                <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>
                    {{ $t }}
                </option>
            @endforeach
        </select>

        <button class="bg-gray-700 text-white px-4 rounded-lg">
            Filter
        </button>

    </form>

    {{-- CARD --}}
    <div class="bg-white rounded-xl shadow p-4">
        <h2 class="text-lg font-semibold mb-4">Dokumen</h2>

        @include('admin.keuangan.partials.table')
    </div>

</div>

@endsection