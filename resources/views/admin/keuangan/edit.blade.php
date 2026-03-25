@extends('layouts.app')

@section('content')

<div class="p-6">

    <h1 class="text-2xl font-semibold mb-6">Edit Dokumen</h1>

    <div class="bg-white p-6 rounded-xl shadow max-w-3xl">

        <form action="{{ route('keuangan.update', [$slug, $data->id_dokumen_keuangan]) }}"
            method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="text" name="nama_dokumen"
                value="{{ $data->nama_dokumen }}"
                class="w-full border p-2 mb-3">

            <input type="date" name="tanggal_dokumen"
                value="{{ $data->tanggal_dokumen }}"
                class="w-full border p-2 mb-3">

            <input type="text" name="created_by"
                value="{{ $data->created_by }}"
                class="w-full border p-2 mb-3">

            <input type="file" name="file" class="mb-3">

            <button class="bg-blue-500 text-white px-4 py-2 rounded">
                Update
            </button>

        </form>

    </div>

</div>

@endsection