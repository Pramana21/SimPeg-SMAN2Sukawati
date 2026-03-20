@extends('layouts.app')

@section('content')

<div class="p-6">

    <!-- TITLE -->
    <h1 class="text-2xl font-semibold mb-1">Audit Log</h1>
    <p class="text-gray-500 mb-6">Catatan aktivitas pengguna di sistem.</p>

    <!-- FILTER -->
    <div class="flex items-center gap-3 mb-4">

        <button class="bg-blue-500 text-white px-4 py-2 rounded">
            Januari
        </button>

        <button class="bg-blue-500 text-white px-4 py-2 rounded">
            2025
        </button>

    </div>

    <!-- ACTION BUTTON -->
    <div class="flex justify-end gap-2 mb-4">

        <button class="bg-blue-500 text-white px-4 py-2 rounded flex items-center gap-2">
            <i data-feather="download"></i>
            Unduh
        </button>

        <button class="bg-red-500 text-white px-4 py-2 rounded flex items-center gap-2">
            <i data-feather="trash"></i>
            Hapus
        </button>

    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow p-4">

        <h2 class="text-lg font-semibold mb-4">
            Aktivitas Terakhir (Audit Log)
        </h2>

        <table class="w-full text-sm">

            <thead>
                <tr class="border-b">
                    <th class="p-2"></th>
                    <th class="p-2 text-left">Waktu</th>
                    <th class="p-2 text-left">Pengguna</th>
                    <th class="p-2 text-left">Modul</th>
                    <th class="p-2 text-left">Aktivitas</th>
                    <th class="p-2 text-left">Keterangan</th>
                </tr>
            </thead>

            <tbody>

                @foreach($logs as $log)
                <tr class="border-b hover:bg-gray-50">

                    <td class="p-2">
                        <input type="checkbox">
                    </td>

                    <td class="p-2">{{ $log['tanggal'] }}</td>
                    <td class="p-2">{{ $log['user'] }}</td>
                    <td class="p-2">{{ $log['modul'] }}</td>
                    <td class="p-2">{{ $log['aksi'] }}</td>
                    <td class="p-2">{{ $log['keterangan'] }}</td>

                </tr>
                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection