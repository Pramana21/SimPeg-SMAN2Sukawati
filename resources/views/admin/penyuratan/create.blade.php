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
    <form class="space-y-4">

        <div>
            <label class="text-sm">No Surat</label>
            <input type="text" class="w-full mt-1 p-3 border rounded-lg">
        </div>

        <div>
            <label class="text-sm">Perihal</label>
            <input type="text" class="w-full mt-1 p-3 border rounded-lg">
        </div>

        <!-- JENIS -->
        <div>
            <label class="text-sm">Jenis Surat (Masuk/Keluar)</label>

            <div class="flex gap-6 mt-2">
                <label class="flex items-center gap-2">
                    <input type="radio" name="jenis" checked> Masuk
                </label>

                <label class="flex items-center gap-2">
                    <input type="radio" name="jenis"> Keluar
                </label>
            </div>
        </div>

        <div>
            <label class="text-sm">Date</label>
            <input type="date" class="w-full mt-1 p-3 border rounded-lg">
        </div>

        <div>
            <label class="text-sm">Nama Pengirim/Penerima</label>
            <input type="text" class="w-full mt-1 p-3 border rounded-lg">
        </div>

        <!-- UPLOAD -->
        <div>
            <label class="text-sm">Upload Surat</label>

            <div class="mt-2 border rounded-xl h-40 flex items-center justify-center">
                <button type="button"
                        class="w-12 h-12 bg-blue-500 text-white rounded-lg text-xl">
                    +
                </button>
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

@endsection