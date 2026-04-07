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

        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Data Siswa</h1>
            <p class="text-sm text-gray-500">Detail informasi siswa SMAN 2 Sukawati</p>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">

        {{-- LEFT --}}
        <div>

            {{-- FOTO --}}
            <div class="rounded-xl bg-white p-4 text-center shadow">

                @if($murid->foto_path)
                    <div class="mx-auto mb-3 w-full max-w-[250px] aspect-square overflow-hidden rounded-lg">
                        <img src="{{ asset('storage/' . $murid->foto_path) }}"
                             class="h-full w-full object-cover object-center">
                    </div>
                @else
                    <div class="mx-auto mb-3 flex w-full max-w-[250px] aspect-square items-center justify-center rounded-lg bg-gray-100">
                        <span class="text-gray-400">No Image</span>
                    </div>
                @endif

                <p class="text-sm text-gray-500">Foto Siswa</p>
            </div>

            {{-- DATA KIRI --}}
            <div class="mt-4 rounded-xl bg-white p-4 shadow">
                <h3 class="mb-2 font-semibold text-gray-800">
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

            <div class="rounded-xl bg-white shadow">

                <div class="border-b px-6 py-4">
                    <h2 class="text-lg font-semibold">Data Pribadi</h2>
                </div>

                <div class="space-y-4 p-6 text-sm text-gray-700">

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
