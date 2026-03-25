@extends('layouts.app')

@section('content')

<div class="flex justify-between mb-4">
    <h1 class="text-2xl font-bold">{{ $title }}</h1>

    <a href="{{ route('keuangan.create', $slug) }}"
        class="bg-blue-500 text-white px-4 py-2 rounded">
        + Tambah
    </a>
</div>

@include('admin.keuangan.partials.table')

@endsection