@extends('layouts.app')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">

        <div class="flex items-center gap-3">
            <a href="{{ route('data-center.index') }}"
               class="w-10 h-10 flex items-center justify-center rounded-full border hover:bg-gray-100">
                ←
            </a>

            <h1 class="text-xl font-semibold text-gray-800">
                Semua Pegawai
            </h1>
        </div>

        <a href="{{ route('pegawai.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
            + Tambah
        </a>

    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-3">No Induk</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Gender</th>
                    <th class="px-4 py-3">Phone</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($data as $item)
                <tr class="border-t hover:bg-gray-50">

                    <td class="px-4 py-3">{{ $item->nip }}</td>

                    <td class="px-4 py-3">
                        <div class="font-medium">{{ $item->nama_pegawai }}</div>
                        <div class="text-xs text-gray-500">{{ $item->email }}</div>
                    </td>

                    <td class="px-4 py-3">{{ $item->status_pegawai }}</td>
                    <td class="px-4 py-3">{{ $item->jenis_kelamin }}</td>
                    <td class="px-4 py-3">{{ $item->no_hp }}</td>

                    <td class="px-4 py-3 text-center space-x-1">

                        <a href="{{ route('pegawai.edit', $item->id_pegawai) }}"
                           class="bg-yellow-500 text-white px-2 py-1 rounded">✏</a>

                        <a href="{{ route('pegawai.show', $item->id_pegawai) }}"
                           class="bg-blue-500 text-white px-2 py-1 rounded">👁</a>

                        <form action="{{ route('pegawai.destroy', $item->id_pegawai) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Hapus data?')"
                                class="bg-red-500 text-white px-2 py-1 rounded">🗑</button>
                        </form>

                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-6 text-gray-400">
                        Belum ada data
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection