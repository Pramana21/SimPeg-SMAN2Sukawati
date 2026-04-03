@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('pegawai.index') }}"
           class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-slate-800 text-slate-800 transition hover:bg-slate-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>

        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Data Pegawai</h1>
            <p class="text-gray-500 text-sm">Detail informasi pegawai SMAN 2 Sukawati</p>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">
        <div>
            <div class="bg-white rounded-xl shadow p-4 text-center">
                @if($pegawai->foto_path)
                    <img src="{{ asset('storage/' . $pegawai->foto_path) }}"
                         class="w-full h-64 object-cover rounded-lg mb-3">
                @else
                    <div class="w-full h-64 flex items-center justify-center bg-gray-100 rounded-lg mb-3">
                        <span class="text-gray-400">No Image</span>
                    </div>
                @endif

                <p class="text-gray-500 text-sm">Foto Pegawai</p>
            </div>

            <div class="bg-white rounded-xl shadow p-4 mt-4">
                <h3 class="font-semibold text-gray-800 mb-2">{{ $pegawai->nama_pegawai }}</h3>
                <p class="text-sm text-gray-600">NIP : {{ $pegawai->nip_nippk ?: '-' }}</p>
                <p class="text-sm text-gray-600">NUPTK : {{ $pegawai->nuptk ?: '-' }}</p>
                <p class="text-sm text-gray-600">NIK : {{ $pegawai->nik ?: '-' }}</p>
                <p class="text-sm text-gray-600">Status : {{ $pegawai->status_pegawai ?: '-' }}</p>
            </div>
        </div>

        <div class="col-span-2">
            <div class="bg-white rounded-xl shadow">
                <div class="border-b px-6 py-4">
                    <h2 class="text-lg font-semibold">Data Pribadi</h2>
                </div>

                <div class="p-6 space-y-4 text-sm text-gray-700">
                    <div class="grid grid-cols-2">
                        <span>Tempat & Tanggal Lahir</span>
                        <span>{{ $pegawai->tanggal_lahir ?: '-' }}</span>
                    </div>

                    <div class="grid grid-cols-2">
                        <span>Jenis Kelamin</span>
                        <span>{{ $pegawai->jenis_kelamin ?: '-' }}</span>
                    </div>

                    <div class="grid grid-cols-2">
                        <span>Pendidikan Terakhir</span>
                        <span>{{ $pegawai->pendidikan_terakhir ?: '-' }}</span>
                    </div>

                    <hr>

                    <div class="grid grid-cols-2">
                        <span>Alamat</span>
                        <span>{{ $pegawai->alamat ?: '-' }}</span>
                    </div>

                    <div class="grid grid-cols-2">
                        <span>No. HP</span>
                        <span>{{ $pegawai->no_hp ?: '-' }}</span>
                    </div>

                    <div class="grid grid-cols-2">
                        <span>Email</span>
                        <span>{{ $pegawai->email ?: '-' }}</span>
                    </div>

                    <div class="grid grid-cols-2">
                        <span>Status Pegawai</span>
                        <span>{{ $pegawai->status_pegawai ?: '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
