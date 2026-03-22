@extends('layouts.app')

@section('content')

<div class="p-6">

    <!-- TITLE -->
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">
        Inventaris
    </h1>

    <!-- FILTER -->
    <div class="flex justify-between items-center mb-4">

        <!-- LEFT -->
        <div class="flex gap-2">
            <button class="px-4 py-1.5 bg-blue-500 text-white rounded-md text-sm flex items-center gap-2">
                Januari <i data-feather="chevron-down"></i>
            </button>

            <button class="px-4 py-1.5 bg-blue-500 text-white rounded-md text-sm flex items-center gap-2">
                2025 <i data-feather="chevron-down"></i>
            </button>
        </div>

        <!-- RIGHT -->
        <a href="/inventaris/create"
           class="flex items-center gap-2 px-4 py-1.5 bg-blue-500 text-white rounded-md text-sm">
            <i data-feather="plus"></i> Tambah
        </a>

    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <h2 class="text-lg font-semibold p-4 border-b">
            Dokumen terbaru
        </h2>

        <table class="w-full text-sm">

            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="p-4 w-10">
                        <input type="checkbox">
                    </th>
                    <th class="p-4">No</th>
                    <th class="p-4">Nama Dokumen</th>
                    <th class="p-4">Tanggal</th>
                    <th class="p-4">Di-upload oleh</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @for ($i = 1; $i <= 5; $i++)
                <tr class="border-t">

                    <td class="p-4">
                        <input type="checkbox">
                    </td>

                    <td class="p-4">0{{ $i }}</td>
                    <td class="p-4">Inventaris barang</td>
                    <td class="p-4">01/{{ $i }}/2025</td>
                    <td class="p-4">Ni Luh Surya</td>

                    <td class="p-4">
                        <div class="flex justify-center gap-2">

                            <button class="bg-green-500 text-white p-2 rounded">
                                <i data-feather="edit"></i>
                            </button>

                            <button class="bg-blue-500 text-white p-2 rounded">
                                <i data-feather="eye"></i>
                            </button>

                            <button class="bg-red-500 text-white p-2 rounded">
                                <i data-feather="trash-2"></i>
                            </button>

                        </div>
                    </td>

                </tr>
                @endfor

            </tbody>

        </table>

    </div>

</div>

@endsection