@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Tambah Dokumen</h1>

<form action="{{ route('keuangan.store', $slug) }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="mb-3">
    <label>Nama Dokumen</label>
    <input type="text" name="nama_dokumen" class="w-full border p-2">
</div>

<div class="mb-3">
    <label>Jenis Dokumen</label>
    <input type="text" value="{{ $kategori->nama_kategori }}" readonly class="w-full border p-2 bg-gray-100">
</div>

<div class="mb-3">
    <label>Tanggal</label>
    <input type="date" name="tanggal_dokumen" class="w-full border p-2">
</div>

<div class="mb-3">
    <label>Upload File</label>
    <input type="file" name="file" class="w-full">
</div>

<button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
    Upload
</button>

</form>

@endsection