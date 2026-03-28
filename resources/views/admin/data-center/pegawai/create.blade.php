@extends('layouts.app')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('pegawai.index') }}"
           class="w-10 h-10 flex items-center justify-center rounded-full border hover:bg-gray-100">
            ←
        </a>

        <h1 class="text-2xl font-semibold text-gray-800">
            Mengisi Data Pegawai
        </h1>
    </div>

    <form action="{{ route('pegawai.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white rounded-2xl shadow p-6 space-y-5">

            {{-- NAMA --}}
            <div>
                <label class="text-sm text-gray-600">Nama Pegawai</label>
                <input type="text" name="nama_pegawai"
                    class="w-full mt-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Contoh: Dika">
            </div>

            {{-- NIP NIK NUPTK --}}
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="text-sm text-gray-600">NIP/NIPPK</label>
                    <input type="text" name="nip"
                        class="w-full mt-1 border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="text-sm text-gray-600">NIK</label>
                    <input type="text" name="nik"
                        class="w-full mt-1 border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="text-sm text-gray-600">NUPTK</label>
                    <input type="text" name="nuptk"
                        class="w-full mt-1 border rounded-lg px-3 py-2">
                </div>
            </div>

            {{-- TANGGAL + GENDER + STATUS --}}
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="text-sm text-gray-600">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir"
                        class="w-full mt-1 border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="text-sm text-gray-600">Gender</label>
                    <select name="jenis_kelamin"
                        class="w-full mt-1 border rounded-lg px-3 py-2">
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Status Pegawai</label>
                    <select name="status_pegawai"
                        class="w-full mt-1 border rounded-lg px-3 py-2">
                        <option>Honor</option>
                        <option>PNS</option>
                        <option>PKKK</option>
                        <option>Kontrak</option>
                        <option>Kontrak Provinsi</option>
                        <option>OJTM</option>
                    </select>
                </div>
            </div>

            {{-- PENDIDIKAN --}}
            <div>
                <label class="text-sm text-gray-600">Pendidikan Terakhir</label>
                <input type="text" name="pendidikan_terakhir"
                    class="w-full mt-1 border rounded-lg px-3 py-2"
                    placeholder="Contoh: Sarjana">
            </div>

            {{-- ALAMAT --}}
            <div>
                <label class="text-sm text-gray-600">Alamat Pegawai</label>
                <input type="text" name="alamat"
                    class="w-full mt-1 border rounded-lg px-3 py-2"
                    placeholder="Contoh: Jl. Raya Sukawati">
            </div>

            {{-- EMAIL --}}
            <div>
                <label class="text-sm text-gray-600">Email Pegawai</label>
                <input type="email" name="email"
                    class="w-full mt-1 border rounded-lg px-3 py-2"
                    placeholder="Contoh: nama@sma.sch.id">
            </div>

            {{-- NO HP --}}
            <div>
                <label class="text-sm text-gray-600">No HP Pegawai</label>
                <input type="text" name="no_hp"
                    class="w-full mt-1 border rounded-lg px-3 py-2"
                    placeholder="Contoh: +628...">
            </div>

            {{-- FOTO --}}
            <div>
                <label class="text-sm text-gray-600">Upload Foto Pegawai</label>

                <div class="mt-2 border-2 border-dashed rounded-lg h-40 flex items-center justify-center cursor-pointer hover:bg-gray-50">
                    <input type="file" name="foto" class="hidden" id="fotoInput">
                    
                    <label for="fotoInput" class="text-center cursor-pointer">
                        <div class="w-12 h-12 bg-blue-500 text-white flex items-center justify-center rounded-lg mx-auto">
                            +
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Klik untuk upload</p>
                    </label>
                </div>
            </div>

            {{-- BUTTON --}}
            <div class="text-center pt-4">
                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">
                    Simpan Data
                </button>
            </div>

        </div>

    </form>

</div>

@endsection