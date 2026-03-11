@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">
Upload Dokumen Pegawai
</h1>

<form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data">

@csrf

<div class="mb-4">

<label>Pilih Pegawai</label>

<select name="pegawai_id" class="border p-2 w-full">

@foreach($pegawai as $p)

<option value="{{ $p->id }}">
{{ $p->nama }}
</option>

@endforeach

</select>

</div>

<div class="mb-4">

<label>Nama Dokumen</label>

<input type="text" name="nama_dokumen" class="border p-2 w-full">

</div>

<div class="mb-4">

<label>Upload File</label>

<input type="file" name="file_dokumen" class="border p-2 w-full">

</div>

<button class="bg-blue-500 text-white px-4 py-2 rounded">

Upload

</button>

</form>

@endsection