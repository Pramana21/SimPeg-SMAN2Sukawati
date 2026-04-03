@extends('layouts.app')

@section('content')

<div class="p-6">

    {{-- TITLE --}}
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">
        Data Center
    </h1>

    {{-- GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl">

        {{-- MURID --}}
        <a href="{{ route('murid.index') }}"
           class="flex items-center gap-4 p-6 border border-blue-300 rounded-2xl hover:shadow-md hover:bg-blue-50 transition">

            <div class="w-14 h-14 flex items-center justify-center bg-blue-500 text-white rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                    <circle cx="10" cy="7" r="4" stroke-width="2" />
                </svg>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Murid
                </h2>
                <p class="text-sm text-gray-500">
                    Data siswa sekolah
                </p>
            </div>

        </a>

        {{-- STAFF / GURU --}}
        <a href="{{ route('pegawai.index') }}"
           class="flex items-center gap-4 p-6 border border-blue-300 rounded-2xl hover:shadow-md hover:bg-blue-50 transition">

            <div class="w-14 h-14 flex items-center justify-center bg-blue-500 text-white rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-3-3.87M7 21v-2a4 4 0 013-3.87M7 7a4 4 0 118 0 4 4 0 01-8 0zm10 1a3 3 0 110 6" />
                </svg>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Staff / Guru
                </h2>
                <p class="text-sm text-gray-500">
                    Data pegawai & pengajar
                </p>
            </div>

        </a>

    </div>

</div>

@endsection
