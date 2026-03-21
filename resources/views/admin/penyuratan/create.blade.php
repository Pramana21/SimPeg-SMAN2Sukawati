@extends('layouts.app')

@section('content')

<div class="p-6 max-w-3xl">

    <!-- BACK + TITLE -->
    <div class="flex items-center gap-3 mb-6">

        <a href="/penyuratan"
           class="w-10 h-10 flex items-center justify-center rounded-full border text-lg">
            ←
        </a>

        <h1 class="text-2xl font-semibold">Tambah Surat</h1>

    </div>

    <!-- FORM -->
    <form action="/penyuratan/store" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- NO SURAT -->
        <div>
            <label class="text-sm">No Surat</label>
            <input type="text" name="no_surat" class="w-full mt-1 p-3 border rounded-lg" required>
        </div>

        <!-- NAMA DOKUMEN -->
        <div>
            <label class="text-sm">Perihal</label>
            <input type="text" name="nama_dokumen" class="w-full mt-1 p-3 border rounded-lg" required>
        </div>

        <!-- JENIS -->
        <div>
            <label class="text-sm">Jenis Surat (Masuk/Keluar)</label>

            <div class="flex gap-6 mt-2">
                @foreach($jenis as $j)
                    <label class="flex items-center gap-2">
                        <input type="radio" name="id_jenis_surat"
                               value="{{ $j->id_jenis_surat }}" required>
                        {{ $j->nama_jenis_surat }}
                    </label>
                @endforeach
            </div>
        </div>

        <!-- TANGGAL -->
        <div>
            <label class="text-sm">Date</label>
            <input type="date" name="tanggal_dokumen" class="w-full mt-1 p-3 border rounded-lg" required>
        </div>

        <!-- PENGIRIM -->
        <div>
            <label class="text-sm">Nama Pengirim/Penerima</label>
            <input type="text" name="nama_pengirim_penerima" class="w-full mt-1 p-3 border rounded-lg">
        </div>

        <!-- UPLOAD -->
        <div>
            <label class="text-sm">Upload Surat</label>

            <div class="mt-2 border rounded-xl h-40 flex items-center justify-center flex-col gap-2">
                <input type="file" name="file_surat" class="hidden" id="fileInput" required>

                <button type="button"
                        onclick="document.getElementById('fileInput').click()"
                        class="w-12 h-12 bg-blue-500 text-white rounded-lg text-xl">
                    +
                </button>

                <span class="text-xs text-gray-400">Upload file</span>
            </div>
        </div>

        <!-- BUTTON -->
        <div class="flex justify-center">
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg">
                Upload
            </button>
        </div>

    </form>

</div>

@endsection