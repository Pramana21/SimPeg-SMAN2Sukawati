@extends('layouts.app')

@section('content')

<div class="p-6 max-w-3xl">

    <!-- BACK + TITLE -->
    <div class="flex items-center gap-3 mb-6">

        <a href="/inventaris"
           class="w-10 h-10 flex items-center justify-center rounded-full border text-lg">
            ←
        </a>

        <h1 class="text-2xl font-semibold">Tambah Dokumen</h1>

    </div>

    <!-- FORM -->
    <form action="/inventaris/store" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <!-- NAMA -->
        <div>
            <label class="text-sm">Nama Dokumen</label>
            <input type="text" name="nama_dokumen"
                   class="w-full mt-1 p-3 border rounded-lg" required>
        </div>

        <!-- TANGGAL -->
        <div>
            <label class="text-sm">Date</label>
            <input type="date" name="tanggal_dokumen"
                   class="w-full mt-1 p-3 border rounded-lg" required>
        </div>

        <!-- UPLOADER -->
        <div>
            <label class="text-sm">Di-upload</label>
            <input type="text" name="created_by"
                   class="w-full mt-1 p-3 border rounded-lg"
                   placeholder="Contoh: Budi">
        </div>

        <!-- UPLOAD -->
        <div>
            <label class="text-sm">Upload Surat</label>

            <div class="mt-2 border rounded-xl h-40 flex flex-col items-center justify-center gap-2">

                <input type="file" name="file_surat" id="fileInput" class="hidden" required>

                <label for="fileInput"
                       class="w-12 h-12 bg-blue-500 text-white rounded-lg flex items-center justify-center text-xl cursor-pointer">
                    +
                </label>

                <span id="fileName" class="text-sm text-gray-500">
                    Upload file
                </span>

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

<!-- SCRIPT TAMPILKAN NAMA FILE -->
<script>
    document.getElementById('fileInput').addEventListener('change', function() {
        const fileName = this.files[0]?.name || "Upload file";
        document.getElementById('fileName').innerText = fileName;
    });
</script>

@endsection