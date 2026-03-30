@extends('layouts.app')

@section('content')
@include('admin.administrasi.partials.submodule', [
    'title' => $title,
    'selectedKategori' => $selectedKategori,
    'createRoute' => $createRoute,
    'tableId' => 'administrasiPegawai',
    'emptyMessage' => 'Data administrasi pegawai belum tersedia untuk filter yang dipilih.',
])
@endsection
