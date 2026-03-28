@extends('layouts.app')

@section('content')

<div class="p-6">

    <div class="bg-white rounded-2xl shadow overflow-hidden">

        {{-- HEADER --}}
        <div class="flex justify-between items-center p-5 border-b">

            <div class="flex items-center gap-3">
                <a href="{{ route('data-center.index') }}"
                   class="w-10 h-10 flex items-center justify-center rounded-full border hover:bg-gray-100">
                    ←
                </a>

                <h1 class="text-xl font-semibold text-gray-800">
                    Semua Siswa
                </h1>
            </div>

            <a href="{{ route('murid.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow flex items-center gap-2">
                + Tambah
            </a>

        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-4 py-3"><input type="checkbox"></th>
                        <th class="px-4 py-3">NIS</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Kelas</th>
                        <th class="px-4 py-3">Gender</th>
                        <th class="px-4 py-3">Phone</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">

                    @forelse ($data as $item)
                    <tr class="border-t hover:bg-gray-50">

                        <td class="px-4 py-3">
                            <input type="checkbox">
                        </td>

                        <td class="px-4 py-3">{{ $item->nis }}</td>

                        <td class="px-4 py-3">
                            <div class="font-medium">{{ $item->nama_siswa }}</div>
                            <div class="text-xs text-gray-500">{{ $item->email }}</div>
                        </td>

                        <td class="px-4 py-3">
                            {{ $item->id_kelas ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $item->jenis_kelamin }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $item->no_hp }}
                        </td>

                        <td class="px-4 py-3 text-center space-x-1">

                            {{-- EDIT --}}
                            <a href="{{ route('murid.edit', $item->id_siswa) }}"
                               class="bg-yellow-500 text-white px-2 py-1 rounded">
                                ✏
                            </a>

                            {{-- PREVIEW --}}
                            <a href="{{ route('murid.show', $item->id_siswa) }}"
                               class="bg-blue-500 text-white px-2 py-1 rounded">
                                👁
                            </a>

                            {{-- DELETE (NEXT STEP) --}}
                            <form action="{{ route('murid.destroy', $item->id_siswa) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')

                                <button onclick="return confirm('Yakin hapus data ini?')"
                                    class="bg-red-500 text-white px-2 py-1 rounded text-xs">
                                    🗑
                                </button>
                            </form>

                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-400">
                            Belum ada data
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- FOOTER --}}
        <div class="flex justify-between items-center p-4 border-t text-sm text-gray-600">

            <div>
                Panjang per halaman
                <select class="border rounded px-2 py-1 ml-2">
                    <option>10</option>
                </select>
            </div>

            <div>
                Page 1
            </div>

        </div>

    </div>

</div>

@endsection