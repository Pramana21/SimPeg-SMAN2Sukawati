@extends('layouts.app')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ url()->previous() }}"
           class="w-10 h-10 flex items-center justify-center rounded-full border hover:bg-gray-100">
            ←
        </a>

        <h1 class="text-2xl font-semibold text-gray-800">
            Tambah Dokumen
        </h1>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow p-6 max-w-3xl">

        <form action="{{ route('keuangan.store', $slug) }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Nama Dokumen --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Nama Dokumen
                </label>
                <input type="text" name="nama_dokumen"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500"
                    placeholder="Nama">
            </div>

            {{-- Jenis Dokumen --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Jenis Dokumen
                </label>
                <div class="w-full bg-blue-100 text-blue-700 rounded-lg px-4 py-3 font-medium">
                    {{ $kategori->nama_kategori }}
                </div>
            </div>

            {{-- Tanggal --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Tanggal
                </label>
                <input type="date" name="tanggal_dokumen"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- DI-UPLOAD --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Di-upload
                </label>
                <input type="text" name="created_by"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500"
                    placeholder="Contoh: Bongtomo">
            </div>

            {{-- 🔥 UPLOAD SURAT (FIXED) --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Upload Surat
                </label>

                <!-- INPUT FILE -->
                <input type="file" name="file" id="fileInput" class="hidden">

                <!-- BOX -->
                <label for="fileInput"
                    class="w-full h-40 border-2 border-dashed border-gray-300 rounded-xl flex items-center justify-center cursor-pointer hover:border-blue-500 transition">

                    <div class="text-center">
                        <div class="w-12 h-12 bg-blue-500 text-white flex items-center justify-center rounded-lg text-2xl mx-auto mb-2">
                            +
                        </div>
                        <p class="text-sm text-gray-500">Klik untuk upload file</p>
                    </div>

                </label>

                <!-- 🔥 NAMA FILE (INI YANG BARU) -->
                <p id="fileName" class="text-sm text-gray-500 mt-2 italic">
                    Belum ada file dipilih
                </p>
            </div>

            {{-- BUTTON --}}
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow">
                Upload
            </button>

        </form>

    </div>

</div>

{{-- 🔥 SCRIPT FIX --}}
<script>
document.getElementById('fileInput').addEventListener('change', function(e) {
    const file = e.target.files[0];

    if (file) {
        document.getElementById('fileName').innerText = file.name;
    } else {
        document.getElementById('fileName').innerText = 'Belum ada file dipilih';
    }
});
</script>

@endsection