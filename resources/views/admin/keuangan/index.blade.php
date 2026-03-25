@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">{{ $title }}</h1>

@include('admin.keuangan.partials.table')

@endsection