@extends('layouts.app')

@section('content')

<div class="p-6">

    <!-- TITLE -->
    <h1 class="text-2xl font-semibold mb-4">
        Administrasi
    </h1>

    <!-- FILTER -->
    <form method="GET" class="flex justify-between items-center mb-4">

        <!-- LEFT -->
        <div class="flex gap-2">

            <!-- KATEGORI -->
            <select name="kategori" class="px-3 py-2 border rounded-lg text-sm">
                <option value="">Kategori</option>
                <option value="Pegawai">Pegawai</option>
                <option value="Siswa">Siswa</option>
            </select>

            <!-- BULAN -->
            <select name="bulan" class="px-3 py-2 border rounded-lg text-sm">
                <option value="">Bulan</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>

            <!-- TAHUN -->
            <select name="tahun" class="px-3 py-2 border rounded-lg text-sm">
                <option value="">Tahun</option>
                @for ($i = 2024; $i <= date('Y'); $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>

            <button class="bg-blue-500 text-white px-4 rounded">
                Filter
            </button>

        </div>

        <!-- RIGHT -->
        <a href="/administrasi/create"
           class="bg-blue-500 text-white px-4 py-2 rounded-lg flex items-center gap-2">
            + Tambah
        </a>

    </form>

    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-50">
                <tr>
                    <th class="p-4">Nama Dokumen</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4">Tanggal</th>
                    <th class="p-4">Upload By</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($data as $d)
                <tr class="border-t">

                    <td class="p-4">{{ $d->nama_dokumen }}</td>

                    <td class="p-4">
                        {{ $d->jenis->kategori->nama_kategori ?? '-' }}
                    </td>

                    <td class="p-4">
                        {{ date('d/m/Y', strtotime($d->tanggal_dokumen)) }}
                    </td>

                    <td class="p-4">{{ $d->created_by }}</td>

                    <td class="p-4 text-center">
                        <div class="flex justify-center gap-2">

                            <!-- VIEW -->
                            <a href="{{ asset('storage/'.$d->file_path) }}"
                               target="_blank"
                               class="bg-blue-500 text-white px-2 py-1 rounded">
                                👁
                            </a>

                            <!-- DELETE -->
                            <form action="/administrasi/{{ $d->id_dokumen_administrasi }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 text-white px-2 py-1 rounded">
                                    🗑
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center p-4">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

    </div>

    <!-- PAGINATION -->
    <div class="mt-4">
        {{ $data->links() }}
    </div>

</div>

@endsection