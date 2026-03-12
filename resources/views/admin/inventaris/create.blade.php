@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">
Tambah Inventaris
</h1>

<form action="{{ route('inventaris.store') }}" method="POST">

@csrf

<div class="mb-4">

<label>Nama Barang</label>

<input type="text" name="nama_barang"
class="border p-2 w-full">

</div>

<div class="mb-4">

<label>Jumlah</label>

<input type="number" name="jumlah"
class="border p-2 w-full">

</div>

<div class="mb-4">

<label>Kondisi</label>

<input type="text" name="kondisi"
class="border p-2 w-full">

</div>

<button class="bg-blue-500 text-white px-4 py-2 rounded">

Simpan

</button>

</form>

@endsection