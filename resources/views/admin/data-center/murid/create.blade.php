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
            Mengisi Data Siswa
        </h1>
    </div>

    <form action="{{ route('murid.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- CARD --}}
        <div class="bg-white p-8 rounded-2xl shadow max-w-4xl">

            {{-- NAMA --}}
            <div class="mb-6">
                <label class="block text-sm text-gray-600 mb-2">Nama Siswa</label>
                <input type="text" name="nama_siswa"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none"
                    placeholder="Contoh: Dika">
            </div>

            {{-- NIS NIK NISN --}}
            <div class="grid grid-cols-3 gap-4 mb-6">
                <input type="text" name="nis" placeholder="NIS"
                    class="rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500">

                <input type="text" name="nik" placeholder="NIK"
                    class="rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500">

                <input type="text" name="nisn" placeholder="NISN"
                    class="rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- TANGGAL + GENDER + KELAS --}}
            <div class="grid grid-cols-3 gap-4 mb-6">

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

            {{-- JENIS KELAS --}}
            <div class="mb-6 hidden" id="jenisKelasWrapper">
                <label id="jenisLabel" class="block text-sm text-gray-600 mb-2"></label>

                <select name="jenis_kelas" id="jenisKelas"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500">
                </select>
            </div>

            {{-- ALAMAT --}}
            <div class="mb-6">
                <label class="block text-sm text-gray-600 mb-2">Alamat Siswa</label>
                <input type="text" name="alamat"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500"
                    placeholder="Contoh: Jalan ...">
            </div>

            {{-- EMAIL --}}
            <div class="mb-6">
                <label class="block text-sm text-gray-600 mb-2">Email Siswa</label>
                <input type="email" name="email"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500"
                    placeholder="Contoh: nama@sma.sch.id">
            </div>

            {{-- HP --}}
            <div class="mb-6">
                <label class="block text-sm text-gray-600 mb-2">No HP Siswa</label>
                <input type="text" name="no_hp"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500"
                    placeholder="Contoh: +628...">
            </div>

            {{-- IBU --}}
            <div class="mb-6">
                <label class="block text-sm text-gray-600 mb-2">Nama Ibu Kandung</label>
                <input type="text" name="nama_ibu_kandung"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500"
                    placeholder="Contoh: Ni Luh...">
            </div>

            {{-- 🔥 UPLOAD FOTO (FIX UI) --}}
            <div class="mb-8">
                <label class="block text-sm text-gray-600 mb-2">Upload Foto Siswa</label>

                <input type="file" name="foto" id="fileInput" class="hidden">

                <label for="fileInput"
                    class="w-full h-40 border-2 border-dashed border-gray-300 rounded-xl flex items-center justify-center cursor-pointer hover:border-blue-500 transition">

                    <div class="text-center">
                        <div class="w-12 h-12 bg-blue-500 text-white flex items-center justify-center rounded-lg text-2xl mx-auto mb-2">
                            +
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
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg shadow">
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
            select.innerHTML += `<option value="E-${i}">E - ${i}</option>`;
        }

    } else if (value === 'XI' || value === 'XII') {
        label.innerText = 'Kelas F';
        wrapper.classList.remove('hidden');

        for (let i = 1; i <= 10; i++) {
            select.innerHTML += `<option value="F-${i}">F - ${i}</option>`;
        }

    } else {
        wrapper.classList.add('hidden');
    }
});

// 🔥 tampilkan nama file
document.getElementById('fileInput').addEventListener('change', function(e) {
    let fileName = e.target.files[0]?.name;
    if (fileName) {
        document.getElementById('fileName').innerText = fileName;
    }
});
</script>

@endsection