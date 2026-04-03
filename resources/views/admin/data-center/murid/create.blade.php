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
            Mengisi Data Siswa
        </h1>
    </div>

    <form action="{{ route('murid.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- CARD --}}
        <div class="max-w-4xl rounded-2xl bg-white p-8 shadow">

            {{-- NAMA --}}
            <div class="mb-6">
                <label class="mb-2 block text-sm text-gray-600">Nama Siswa</label>
                <input type="text" name="nama_siswa"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Contoh: Dika">
            </div>

            {{-- NIS NIK NISN --}}
            <div class="mb-6 grid grid-cols-3 gap-4">
                <input type="text" name="nis" placeholder="NIS"
                    class="rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500">

                <input type="text" name="nik" placeholder="NIK"
                    class="rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500">

                <input type="text" name="nisn" placeholder="NISN"
                    class="rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- TANGGAL + GENDER + KELAS --}}
            <div class="mb-6 grid grid-cols-3 gap-4">

                <input type="date" name="tanggal_lahir"
                    class="rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500">

                <select name="jenis_kelamin"
                    class="rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500">
                    <option value="">Gender</option>
                    <option>Laki-laki</option>
                    <option>Perempuan</option>
                </select>

                <select id="kelas" name="kelas"
                    class="rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Kelas</option>
                    <option value="X">X</option>
                    <option value="XI">XI</option>
                    <option value="XII">XII</option>
                </select>

            </div>

            {{-- NOMOR KATEGORI --}}
            <div class="mb-6 hidden" id="jenisKelasWrapper">
                <label id="jenisLabel" class="mb-2 block text-sm text-gray-600"></label>

                <select name="nomor_kelas" id="jenisKelas"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500">
                </select>

                <p id="kategoriPreview" class="mt-2 text-sm font-medium text-blue-600"></p>
            </div>

            {{-- ALAMAT --}}
            <div class="mb-6">
                <label class="mb-2 block text-sm text-gray-600">Alamat Siswa</label>
                <input type="text" name="alamat"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500"
                    placeholder="Contoh: Jalan ...">
            </div>

            {{-- EMAIL --}}
            <div class="mb-6">
                <label class="mb-2 block text-sm text-gray-600">Email Siswa</label>
                <input type="email" name="email"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500"
                    placeholder="Contoh: nama@sma.sch.id">
            </div>

            {{-- HP --}}
            <div class="mb-6">
                <label class="mb-2 block text-sm text-gray-600">No HP Siswa</label>
                <input type="text" name="no_hp"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500"
                    placeholder="Contoh: +628...">
            </div>

            {{-- IBU --}}
            <div class="mb-6">
                <label class="mb-2 block text-sm text-gray-600">Nama Ibu Kandung</label>
                <input type="text" name="nama_ibu_kandung"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500"
                    placeholder="Contoh: Ni Luh...">
            </div>

            {{-- UPLOAD FOTO --}}
            <div class="mb-8">
                <label class="mb-2 block text-sm text-gray-600">Upload Foto Siswa</label>

                <input type="file" name="foto" id="fileInput" class="hidden">

                <label for="fileInput"
                    class="flex h-40 w-full cursor-pointer items-center justify-center rounded-xl border-2 border-dashed border-gray-300 transition hover:border-blue-500">

                    <div class="text-center">
                        <div class="mx-auto mb-2 flex h-12 w-12 items-center justify-center rounded-lg bg-blue-500 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <p id="fileName" class="text-sm text-gray-500">
                            Klik untuk upload foto
                        </p>
                    </div>

                </label>
            </div>

            {{-- BUTTON --}}
            <div class="text-center">
                <button
                    class="rounded-lg bg-blue-600 px-8 py-3 text-white shadow hover:bg-blue-700">
                    Simpan data
                </button>
            </div>

        </div>

    </form>

</div>

{{-- JS --}}
<script>
document.getElementById('kelas').addEventListener('change', function() {
    let value = this.value;
    let wrapper = document.getElementById('jenisKelasWrapper');
    let select = document.getElementById('jenisKelas');
    let label = document.getElementById('jenisLabel');

    select.innerHTML = '';

    if (value === 'X') {
        label.innerText = 'Kelas E';
        wrapper.classList.remove('hidden');

        for (let i = 1; i <= 10; i++) {
            select.innerHTML += `<option value="${i}">Nomor ${i}</option>`;
        }

    } else if (value === 'XI' || value === 'XII') {
        label.innerText = 'Kelas F';
        wrapper.classList.remove('hidden');

        for (let i = 1; i <= 10; i++) {
            select.innerHTML += `<option value="${i}">Nomor ${i}</option>`;
        }

    } else {
        wrapper.classList.add('hidden');
    }

    updateKategoriPreview();
});

function updateKategoriPreview() {
    const kelas = document.getElementById('kelas').value;
    const nomor = document.getElementById('jenisKelas').value;
    const preview = document.getElementById('kategoriPreview');

    if (!kelas || !nomor) {
        preview.innerText = '';
        return;
    }

    const prefix = kelas === 'X' ? 'E' : 'F';
    preview.innerText = `Kategori otomatis: ${prefix} - ${nomor}`;
}

document.getElementById('jenisKelas').addEventListener('change', updateKategoriPreview);

document.getElementById('fileInput').addEventListener('change', function(e) {
    let fileName = e.target.files[0]?.name;
    if (fileName) {
        document.getElementById('fileName').innerText = fileName;
    }
});
</script>

@endsection
