@extends('layouts.app')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('murid.index') }}"
           class="w-10 h-10 flex items-center justify-center rounded-full border hover:bg-gray-100">
            ←
        </a>

        <h1 class="text-2xl font-semibold text-gray-800">
            Edit Data Siswa
        </h1>
    </div>

    <form action="{{ route('murid.update', $murid->id_siswa) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl shadow p-6 max-w-4xl">

            {{-- NAMA --}}
            <div class="mb-5">
                <label class="block text-sm text-gray-600 mb-2">Nama Siswa</label>
                <input type="text" name="nama_siswa"
                    value="{{ $murid->nama_siswa }}"
                    class="w-full rounded-lg border px-4 py-3">
            </div>

            {{-- GRID --}}
            <div class="grid grid-cols-3 gap-4 mb-5">
                <input type="text" name="nis" value="{{ $murid->nis }}" placeholder="NIS"
                    class="border px-3 py-2 rounded-lg">

                <input type="text" name="nik" value="{{ $murid->nik }}" placeholder="NIK"
                    class="border px-3 py-2 rounded-lg">

                <input type="text" name="nisn" value="{{ $murid->nisn }}" placeholder="NISN"
                    class="border px-3 py-2 rounded-lg">
            </div>

            <div class="grid grid-cols-3 gap-4 mb-5">

                <input type="date" name="tanggal_lahir"
                    value="{{ $murid->tanggal_lahir }}"
                    class="border px-3 py-2 rounded-lg">

                <select name="jenis_kelamin" class="border px-3 py-2 rounded-lg">
                    <option value="Laki-laki" {{ $murid->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>
                        Laki-laki
                    </option>
                    <option value="Perempuan" {{ $murid->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                        Perempuan
                    </option>
                </select>

                <select id="kelas" name="kelas" class="border px-3 py-2 rounded-lg">
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
                <label id="jenisLabel" class="block text-sm text-gray-600 mb-2">Kategori Kelas</label>
                <select name="nomor_kelas" id="jenisKelas" class="w-full border px-3 py-2 rounded-lg"></select>
                <p id="kategoriPreview" class="mt-2 text-sm font-medium text-blue-600"></p>
            </div>

            {{-- ALAMAT --}}
            <div class="mb-5">
                <input type="text" name="alamat"
                    value="{{ $murid->alamat }}"
                    placeholder="Alamat"
                    class="w-full border px-3 py-2 rounded-lg">
            </div>

            {{-- EMAIL --}}
            <div class="mb-5">
                <input type="email" name="email"
                    value="{{ $murid->email }}"
                    placeholder="Email"
                    class="w-full border px-3 py-2 rounded-lg">
            </div>

            {{-- HP --}}
            <div class="mb-5">
                <input type="text" name="no_hp"
                    value="{{ $murid->no_hp }}"
                    placeholder="No HP"
                    class="w-full border px-3 py-2 rounded-lg">
            </div>

            {{-- IBU --}}
            <div class="mb-5">
                <input type="text" name="nama_ibu_kandung"
                    value="{{ $murid->nama_ibu_kandung }}"
                    placeholder="Nama Ibu Kandung"
                    class="w-full border px-3 py-2 rounded-lg">
            </div>

            {{-- FOTO --}}
            <div class="mb-6">
                <label class="text-sm text-gray-600">Foto Saat Ini</label>

                @if($murid->foto_path)
                    <img src="{{ asset('storage/' . $murid->foto_path) }}"
                         class="w-32 h-32 object-cover rounded mb-2">
                @endif

                <input type="file" name="foto" class="w-full">
            </div>

            <button class="bg-blue-600 text-white px-6 py-3 rounded-lg">
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
