@extends('layouts.app')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('murid.index') }}"
           class="w-10 h-10 flex items-center justify-center rounded-full border hover:bg-gray-100">
            ←
        </a>

        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Data Siswa</h1>
            <p class="text-gray-500 text-sm">Detail informasi siswa SMAN 2 Sukawati</p>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">

        {{-- LEFT --}}
        <div>

            {{-- FOTO --}}
            <div class="bg-white rounded-xl shadow p-4 text-center">

                @if($murid->foto_path)
                    <img src="{{ asset('storage/' . $murid->foto_path) }}"
                         class="w-full h-64 object-cover rounded-lg mb-3">
                @else
                    <div class="w-full h-64 flex items-center justify-center bg-gray-100 rounded-lg mb-3">
                        <span class="text-gray-400">No Image</span>
                    </div>
                @endif

                <p class="text-gray-500 text-sm">Foto Siswa</p>
            </div>

            {{-- DATA KIRI --}}
            <div class="bg-white rounded-xl shadow p-4 mt-4">
                <h3 class="font-semibold text-gray-800 mb-2">
                    {{ $murid->nama_siswa }}
                </h3>

                <p class="text-sm text-gray-600">NIS : {{ $murid->nis }}</p>
                <p class="text-sm text-gray-600">NISN : {{ $murid->nisn }}</p>
                <p class="text-sm text-gray-600">NIK : {{ $murid->nik }}</p>

                <p class="text-sm text-gray-600">
                    Kelas :
                    {{ $murid->kelas ?? '-' }}
                </p>

                <p class="text-sm text-gray-600">
                    Kategori :
                    {{ $murid->kategori_kelas ?? '-' }}
                </p>
            </div>

        </div>

        {{-- RIGHT --}}
        <div class="col-span-2">

            <div class="bg-white rounded-xl shadow">

                <div class="border-b px-6 py-4">
                    <h2 class="text-lg font-semibold">Data Pribadi</h2>
                </div>

                <div class="p-6 space-y-4 text-sm text-gray-700">

                    <div class="grid grid-cols-2">
                        <span>Tempat & Tanggal Lahir</span>
                        <span>{{ $murid->tanggal_lahir }}</span>
                    </div>

                    <div class="grid grid-cols-2">
                        <span>Jenis Kelamin</span>
                        <span>{{ $murid->jenis_kelamin }}</span>
                    </div>

                    <div class="grid grid-cols-2">
                        <span>Kelas</span>
                        <span>{{ $murid->kelas ?? '-' }}</span>
                    </div>

                    <div class="grid grid-cols-2">
                        <span>Kategori Kelas</span>
                        <span>{{ $murid->kategori_kelas ?? '-' }}</span>
                    </div>

                    <hr>

                    <div class="grid grid-cols-2">
                        <span>Alamat</span>
                        <span>{{ $murid->alamat }}</span>
                    </div>

                    <div class="grid grid-cols-2">
                        <span>Nama Ibu Kandung</span>
                        <span>{{ $murid->nama_ibu_kandung }}</span>
                    </div>

                    <div class="grid grid-cols-2">
                        <span>No. HP</span>
                        <span>{{ $murid->no_hp }}</span>
                    </div>

                    <div class="grid grid-cols-2">
                        <span>Email</span>
                        <span>{{ $murid->email }}</span>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
