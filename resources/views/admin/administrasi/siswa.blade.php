@extends('layouts.app')

@section('content')
@include('admin.administrasi.partials.submodule', [
    'title' => $title,
    'selectedKategori' => $selectedKategori,
    'createRoute' => $createRoute,
    'tableId' => 'administrasiSiswa',
    'emptyMessage' => 'Data administrasi siswa belum tersedia untuk filter yang dipilih.',
])
@endsection
