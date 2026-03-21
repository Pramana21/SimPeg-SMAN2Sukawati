
@extends('layouts.app')

@section('content')

<div class="p-6">

    <!-- TITLE -->
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">
        Penyuratan
    </h1>

    <!-- FILTER -->
    <div class="flex justify-between items-center mb-4">

        <!-- LEFT -->
        <div class="flex gap-2">
            <button class="px-4 py-1.5 bg-blue-500 text-white rounded-md text-sm">All</button>
            <button class="px-4 py-1.5 bg-blue-500 text-white rounded-md text-sm">Masuk</button>
            <button class="px-4 py-1.5 bg-blue-500 text-white rounded-md text-sm">Keluar</button>
        </div>

        <!-- RIGHT -->
        <div class="flex gap-2 items-center">
            <button class="px-4 py-1.5 bg-blue-500 text-white rounded-md text-sm">Januari</button>
            <button class="px-4 py-1.5 bg-blue-500 text-white rounded-md text-sm">2025</button>

            <a href="/penyuratan/create"
               class="flex items-center gap-2 px-4 py-1.5 bg-blue-500 text-white rounded-md text-sm">
                <span class="text-lg">+</span> Tambah
            </a>
        </div>

    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-50 text-gray-700">
                <tr class="text-left">
                    <th class="p-4 w-10">
                        <input type="checkbox">
                    </th>
                    <th class="p-4 font-semibold">No Surat</th>
                    <th class="p-4 font-semibold">Nama Surat</th>
                    <th class="p-4 font-semibold">Jenis</th>
                    <th class="p-4 font-semibold">Pengirim</th>
                    <th class="p-4 font-semibold">Tanggal</th>
                    <th class="p-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @foreach($surat as $s)
                <tr class="border-t">

                    <td class="p-4 text-center">
                        <input type="checkbox">
                    </td>

                    <td class="p-4">{{ $s['no'] }}</td>
                    <td class="p-4">{{ $s['nama'] }}</td>
                    <td class="p-4">{{ $s['jenis'] }}</td>
                    <td class="p-4">{{ $s['pengirim'] }}</td>
                    <td class="p-4">{{ $s['tanggal'] }}</td>

                    <!-- AKSI -->
                    <td class="p-4">
                        <div class="flex justify-center gap-2">

                            <!-- EDIT -->
                            <button class="bg-green-500 hover:bg-green-600 text-white p-2 rounded">
                                ✏️
                            </button>

                            <!-- VIEW -->
                            <button class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded">
                                👁
                            </button>

                            <!-- DELETE -->
                            <button class="bg-red-500 hover:bg-red-600 text-white p-2 rounded">
                                🗑
                            </button>

                        </div>
                    </td>

                </tr>
                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection