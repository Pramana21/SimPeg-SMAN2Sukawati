@extends('layouts.app')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('pegawai.index') }}"
           class="w-10 h-10 flex items-center justify-center border rounded-full">
            ←
        </a>

        <div>
            <h1 class="text-2xl font-semibold">Data Pegawai</h1>
            <p class="text-gray-500 text-sm">Detail informasi pegawai</p>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">

        {{-- FOTO --}}
        <div>
            <div class="bg-white rounded-xl shadow p-4 text-center">

                <img src="{{ $pegawai->foto_path ? asset('storage/'.$pegawai->foto_path) : 'https://via.placeholder.com/300' }}"
                     class="w-full h-64 object-cover rounded-lg mb-3">

                <p class="text-gray-500 text-sm">Foto Pegawai</p>
            </div>

            <div class="bg-white rounded-xl shadow p-4 mt-4">
                <h3 class="font-semibold">{{ $pegawai->nama_pegawai }}</h3>

                <p class="text-sm">NIP: {{ $pegawai->nip }}</p>
                <p class="text-sm">NUPTK: {{ $pegawai->nuptk }}</p>
                <p class="text-sm">NIK: {{ $pegawai->nik }}</p>
            </div>
        </div>

        {{-- DATA --}}
        <div class="col-span-2">

            <div class="bg-white rounded-xl shadow">

                <div class="border-b px-6 py-4">
                    <h2 class="font-semibold">Data Pribadi</h2>
                </div>

                <div class="p-6 space-y-3 text-sm">

                    <div class="grid grid-cols-2">
                        <span>Tanggal Lahir</span>
                        <span>{{ $pegawai->tanggal_lahir }}</span>
                    </div>

                    <div class="grid grid-cols-2">
                        <span>Jenis Kelamin</span>
                        <span>{{ $pegawai->jenis_kelamin }}</span>
                    </div>

                    <hr>

                    <div class="grid grid-cols-2">
                        <span>Alamat</span>
                        <span>{{ $pegawai->alamat }}</span>
                    </div>

                    <div class="grid grid-cols-2">
                        <span>Pendidikan</span>
                        <span>{{ $pegawai->pendidikan_terakhir }}</span>
                    </div>

                    <div class="grid grid-cols-2">
                        <span>No HP</span>
                        <span>{{ $pegawai->no_hp }}</span>
                    </div>

                    <div class="grid grid-cols-2">
                        <span>Email</span>
                        <span>{{ $pegawai->email }}</span>
                    </div>

                    <div class="grid grid-cols-2">
                        <span>Status</span>
                        <span>{{ $pegawai->status_pegawai }}</span>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection