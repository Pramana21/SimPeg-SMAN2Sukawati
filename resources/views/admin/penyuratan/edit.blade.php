@extends('layouts.app')

@section('content')

<div class="p-6 max-w-3xl">

    <div class="flex items-center gap-3 mb-6">
        <a href="/penyuratan"
           class="w-10 h-10 flex items-center justify-center rounded-full border text-lg">
            ←
        </a>

        <h1 class="text-2xl font-semibold">Edit Surat</h1>
    </div>

    <form action="/penyuratan/{{ $surat->id_dokumen_penyuratan }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- NO SURAT -->
        <div class="mb-4">
            <label>No Surat</label>
            <input type="text" name="no_surat" value="{{ $surat->no_surat }}" class="w-full p-2 border rounded">
        </div>

        <!-- NAMA -->
        <div class="mb-4">
            <label>Perihal</label>
            <input type="text" name="nama_dokumen" value="{{ $surat->nama_dokumen }}" class="w-full p-2 border rounded">
        </div>

        <!-- JENIS -->
        <div class="mb-4">
            <label>Jenis</label>
            <div class="flex gap-4 mt-2">
                @foreach($jenis as $j)
                    <label>
                        <input type="radio" name="id_jenis_surat"
                               value="{{ $j->id_jenis_surat }}"
                               {{ $surat->id_jenis_surat == $j->id_jenis_surat ? 'checked' : '' }}>
                        {{ $j->nama_jenis_surat }}
                    </label>
                @endforeach
            </div>
        </div>

        <!-- TANGGAL -->
        <div class="mb-4">
            <label>Tanggal</label>
            <input type="date" name="tanggal_dokumen"
                   value="{{ $surat->tanggal_dokumen }}"
                   class="w-full p-2 border rounded">
        </div>

        <!-- PENGIRIM -->
        <div class="mb-4">
            <label>Pengirim</label>
            <input type="text" name="nama_pengirim_penerima"
                   value="{{ $surat->nama_pengirim_penerima }}"
                   class="w-full p-2 border rounded">
        </div>

        <!-- FILE -->
        <div class="mb-4">
            <label>Upload File Baru (Optional)</label>
            <input type="file" name="file_surat" class="w-full">
        </div>

        <button class="bg-blue-500 text-white px-4 py-2 rounded">
            Update
        </button>

    </form>

</div>

@endsection