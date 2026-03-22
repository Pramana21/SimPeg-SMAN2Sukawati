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
        <form method="GET" class="flex gap-2">

            <!-- BULAN -->
            <select name="bulan"
                    onchange="this.form.submit()"
                    class="px-4 py-1.5 bg-blue-500 text-white rounded-md text-sm">

                <option value="">Semua Bulan</option>

                @for($i=1; $i<=12; $i++)
                    <option value="{{ $i }}"
                        {{ request('bulan') == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                    </option>
                @endfor

            </select>

            <!-- TAHUN -->
            <select name="tahun"
                    onchange="this.form.submit()"
                    class="px-4 py-1.5 bg-blue-500 text-white rounded-md text-sm">

                <option value="">Semua Tahun</option>

                @for($y = date('Y'); $y >= 2020; $y--)
                    <option value="{{ $y }}"
                        {{ request('tahun') == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endfor

            </select>

        </form>

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

                @forelse($data as $item)
                <tr class="border-t">

                    <td class="p-4">
                        <input type="checkbox">
                    </td>

                    <td class="p-4">
                        {{ $loop->iteration }}
                    </td>

                    <td class="p-4">
                        {{ $item->nama_dokumen }}
                    </td>

                    <td class="p-4">
                        {{ \Carbon\Carbon::parse($item->tanggal_dokumen)->format('d/m/Y') }}
                    </td>

                    <td class="p-4">
                        {{ $item->created_by }}
                    </td>

                    <td class="p-4">
                        <div class="flex justify-center gap-2">

                            <!-- EDIT -->
                            <a href="/inventaris/edit/{{ $item->id_dokumen_inventaris }}"
                               class="bg-green-500 text-white p-2 rounded">
                                <i data-feather="edit"></i>
                            </a>

                            <!-- PREVIEW -->
                            <a href="{{ asset('storage/'.$item->file_path) }}"
                               target="_blank"
                               class="bg-blue-500 text-white p-2 rounded">
                                <i data-feather="eye"></i>
                            </a>

                            <!-- DELETE -->
                            <form action="/inventaris/{{ $item->id_dokumen_inventaris }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button class="bg-red-500 text-white p-2 rounded">
                                    <i data-feather="trash-2"></i>
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="6" class="text-center p-6 text-gray-500">
                        Data belum ada
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

        <!-- PAGINATION -->
        <div class="p-4">
            {{ $data->appends(request()->query())->links() }}
        </div>

    </div>

</div>

@endsection