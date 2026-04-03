@extends('layouts.app')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('murid.index') }}"
           class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-slate-800 text-slate-800 transition hover:bg-slate-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>

        <h1 class="text-2xl font-semibold text-gray-800">
            Edit Data Siswa
        </h1>
    </div>

    <form action="{{ route('murid.update', $murid->id_siswa) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="max-w-4xl rounded-2xl bg-white p-6 shadow">

            {{-- NAMA --}}
            <div class="mb-5">
                <label class="mb-2 block text-sm text-gray-600">Nama Siswa</label>
                <input type="text" name="nama_siswa"
                    value="{{ $murid->nama_siswa }}"
                    class="w-full rounded-lg border px-4 py-3">
            </div>

            {{-- GRID --}}
            <div class="mb-5 grid grid-cols-3 gap-4">
                <input type="text" name="nis" value="{{ $murid->nis }}" placeholder="NIS"
                    class="rounded-lg border px-3 py-2">

                <input type="text" name="nik" value="{{ $murid->nik }}" placeholder="NIK"
                    class="rounded-lg border px-3 py-2">

                <input type="text" name="nisn" value="{{ $murid->nisn }}" placeholder="NISN"
                    class="rounded-lg border px-3 py-2">
            </div>

            <div class="mb-5 grid grid-cols-3 gap-4">

                <input type="date" name="tanggal_lahir"
                    value="{{ $murid->tanggal_lahir }}"
                    class="rounded-lg border px-3 py-2">

                <select name="jenis_kelamin" class="rounded-lg border px-3 py-2">
                    <option value="Laki-laki" {{ $murid->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>
                        Laki-laki
                    </option>
                    <option value="Perempuan" {{ $murid->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                        Perempuan
                    </option>
                </select>

                <select id="kelas" name="kelas" class="rounded-lg border px-3 py-2">
                    <option value="">Pilih Kelas</option>
                    <option value="X" {{ $murid->kelas === 'X' ? 'selected' : '' }}>X</option>
                    <option value="XI" {{ $murid->kelas === 'XI' ? 'selected' : '' }}>XI</option>
                    <option value="XII" {{ $murid->kelas === 'XII' ? 'selected' : '' }}>XII</option>
                </select>
            </div>

            @php
                $existingNomorKelas = null;

                if (!empty($murid->kategori_kelas) && preg_match('/(\d+)$/', $murid->kategori_kelas, $matches)) {
                    $existingNomorKelas = $matches[1];
                }
            @endphp

            <div class="mb-5" id="jenisKelasWrapper">
                <label id="jenisLabel" class="mb-2 block text-sm text-gray-600">Kategori Kelas</label>
                <select name="nomor_kelas" id="jenisKelas" class="w-full rounded-lg border px-3 py-2"></select>
                <p id="kategoriPreview" class="mt-2 text-sm font-medium text-blue-600"></p>
            </div>

            {{-- ALAMAT --}}
            <div class="mb-5">
                <input type="text" name="alamat"
                    value="{{ $murid->alamat }}"
                    placeholder="Alamat"
                    class="w-full rounded-lg border px-3 py-2">
            </div>

            {{-- EMAIL --}}
            <div class="mb-5">
                <input type="email" name="email"
                    value="{{ $murid->email }}"
                    placeholder="Email"
                    class="w-full rounded-lg border px-3 py-2">
            </div>

            {{-- HP --}}
            <div class="mb-5">
                <input type="text" name="no_hp"
                    value="{{ $murid->no_hp }}"
                    placeholder="No HP"
                    class="w-full rounded-lg border px-3 py-2">
            </div>

            {{-- IBU --}}
            <div class="mb-5">
                <input type="text" name="nama_ibu_kandung"
                    value="{{ $murid->nama_ibu_kandung }}"
                    placeholder="Nama Ibu Kandung"
                    class="w-full rounded-lg border px-3 py-2">
            </div>

            {{-- FOTO --}}
            <div class="mb-6">
                <label class="text-sm text-gray-600">Foto Saat Ini</label>

                @if($murid->foto_path)
                    <img src="{{ asset('storage/' . $murid->foto_path) }}"
                         class="mb-2 h-32 w-32 rounded object-cover">
                @endif

                <input type="file" name="foto" class="w-full">
            </div>

            <button class="rounded-lg bg-blue-600 px-6 py-3 text-white">
                Update Data
            </button>

        </div>

    </form>

</div>

<script>
    const kelasSelect = document.getElementById('kelas');
    const jenisKelasSelect = document.getElementById('jenisKelas');
    const jenisLabel = document.getElementById('jenisLabel');
    const kategoriPreview = document.getElementById('kategoriPreview');
    const existingNomorKelas = @json($existingNomorKelas);

    function populateKategoriOptions() {
        const kelas = kelasSelect.value;
        jenisKelasSelect.innerHTML = '';

        if (!kelas) {
            jenisLabel.innerText = 'Kategori Kelas';
            kategoriPreview.innerText = '';
            return;
        }

        const prefix = kelas === 'X' ? 'E' : 'F';
        jenisLabel.innerText = `Kelas ${prefix}`;

        for (let i = 1; i <= 10; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = `Nomor ${i}`;

            if (String(existingNomorKelas) === String(i)) {
                option.selected = true;
            }

            jenisKelasSelect.appendChild(option);
        }

        updateKategoriPreview();
    }

    function updateKategoriPreview() {
        const kelas = kelasSelect.value;
        const nomor = jenisKelasSelect.value;

        if (!kelas || !nomor) {
            kategoriPreview.innerText = '';
            return;
        }

        const prefix = kelas === 'X' ? 'E' : 'F';
        kategoriPreview.innerText = `Kategori otomatis: ${prefix} - ${nomor}`;
    }

    kelasSelect.addEventListener('change', function () {
        populateKategoriOptions();
    });

    jenisKelasSelect.addEventListener('change', updateKategoriPreview);
    populateKategoriOptions();
</script>

@endsection
