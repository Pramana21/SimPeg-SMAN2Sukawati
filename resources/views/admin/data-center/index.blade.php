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
                <i data-feather="user"></i>
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
        <a href="#"
           class="flex items-center gap-4 p-6 border border-blue-300 rounded-2xl hover:shadow-md hover:bg-blue-50 transition">

            <div class="w-14 h-14 flex items-center justify-center bg-blue-500 text-white rounded-full">
                <i data-feather="users"></i>
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