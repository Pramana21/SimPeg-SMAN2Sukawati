@extends('layouts.app')

@section('content')

<div class="p-6">

    <h1 class="text-2xl font-semibold mb-6">Overview Keuangan</h1>

    <div class="bg-white rounded-xl shadow p-4">
        <h2 class="text-lg font-semibold mb-4">Dokumen Terbaru</h2>

        @include('admin.keuangan.partials.table')
    </div>

</div>

@endsection