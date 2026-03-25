@extends('layouts.app')

@section('content')

<div class="p-6">

    <h1 class="text-2xl font-semibold mb-6 text-gray-800">
        {{ $title }}
    </h1>

    <div class="bg-white rounded-2xl shadow p-5">
        <h2 class="text-lg font-semibold mb-4">
            Dokumen
        </h2>

        @include('admin.keuangan.partials.table')
    </div>

</div>

@endsection