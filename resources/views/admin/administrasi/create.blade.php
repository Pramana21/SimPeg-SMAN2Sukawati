@extends('layouts.app')

@section('content')

<div class="p-6 max-w-3xl" x-data="{ kategori: 'Pegawai' }">

    <!-- BACK + TITLE -->
    <div class="flex items-center gap-3 mb-6">

        <a href="/administrasi"
           class="w-10 h-10 flex items-center justify-center rounded-full border text-lg">
            ←
        </a>

        <h1 class="text-2xl font-semibold">
            Tambah Dokumen
        </h1>

    </div>

    <!-- FORM -->
    <form action="/administrasi/store" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- NAMA -->
        <div>
            <label class="text-sm">Nama Dokumen</label>
            <input type="text" name="nama_dokumen"
                   class="w-full mt-1 p-3 border rounded-lg">
        </div>

        <!-- KATEGORI -->
        <div>
            <label class="text-sm">Kategori</label>

            <div class="flex gap-6 mt-2">

                <label class="flex items-center gap-2">
                    <input type="radio" value="Pegawai" x-model="kategori">
                    Pegawai
                </label>

                <label class="flex items-center gap-2">
                    <input type="radio" value="Siswa" x-model="kategori">
                    Siswa
                </label>

            </div>
        </div>

        <!-- JENIS DOKUMEN DINAMIS -->
        <div>
            <label class="text-sm">Jenis Dokumen</label>

            <!-- PEGAWAI -->
            <div x-show="kategori === 'Pegawai'" class="flex gap-6 mt-2">

                @foreach($jenis->where('kategori.nama_kategori','Pegawai') as $j)
                <label class="flex items-center gap-2">
                    <input type="radio"
                           name="id_jenis_dokumen_administrasi"
                           value="{{ $j->id_jenis_dokumen_administrasi }}">
                    {{ $j->nama_jenis }}
                </label>
                @endforeach

            </div>

            <!-- SISWA -->
            <div x-show="kategori === 'Siswa'" class="flex gap-6 mt-2">

                @foreach($jenis->where('kategori.nama_kategori','Siswa') as $j)
                <label class="flex items-center gap-2">
                    <input type="radio"
                           name="id_jenis_dokumen_administrasi"
                           value="{{ $j->id_jenis_dokumen_administrasi }}">
                    {{ $j->nama_jenis }}
                </label>
                @endforeach

            </div>

        </div>

        <!-- DATE -->
        <div>
            <label class="text-sm">Date</label>
            <input type="date" name="tanggal_dokumen"
                   class="w-full mt-1 p-3 border rounded-lg">
        </div>

        <!-- UPLOADER -->
        <div>
            <label class="text-sm">Di-upload oleh</label>
            <input type="text"
                   value="{{ auth()->user()->username }}"
                   class="w-full mt-1 p-3 border rounded-lg bg-gray-100"
                   readonly>
        </div>

        <!-- UPLOAD FILE (IMPROVED UI) -->
        <div>
            <label class="text-sm">Upload Surat</label>

            <div class="mt-2 border rounded-xl h-40 flex flex-col items-center justify-center">

                <input type="file" name="file_surat" id="fileInput" class="hidden">

                <button type="button"
                        onclick="document.getElementById('fileInput').click()"
                        class="w-12 h-12 bg-blue-500 text-white rounded-lg text-xl">
                    +
                </button>

                <p id="fileName" class="text-sm text-gray-500 mt-2">
                    Upload file
                </p>

            </div>
        </div>

        <!-- BUTTON -->
        <div class="flex justify-center">
            <button class="bg-blue-500 text-white px-6 py-2 rounded-lg">
                Upload
            </button>
        </div>

    </form>

</div>

<!-- SCRIPT NAMA FILE -->
<script>
document.getElementById('fileInput').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'Upload file';
    document.getElementById('fileName').innerText = fileName;
});
</script>

@endsection