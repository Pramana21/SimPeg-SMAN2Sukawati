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
            <a href="/penyuratan"
            class="px-4 py-1.5 {{ !request('jenis') ? 'bg-blue-600' : 'bg-blue-500' }} text-white rounded-md text-sm">
                All
            </a>

            <a href="/penyuratan?jenis=masuk"
            class="px-4 py-1.5 {{ request('jenis') == 'masuk' ? 'bg-blue-600' : 'bg-blue-500' }} text-white rounded-md text-sm">
                Masuk
            </a>

            <a href="/penyuratan?jenis=keluar"
            class="px-4 py-1.5 {{ request('jenis') == 'keluar' ? 'bg-blue-600' : 'bg-blue-500' }} text-white rounded-md text-sm">
                Keluar
            </a>
        </div>

        <!-- RIGHT -->
        <div class="flex gap-2 items-center">

            <!-- BULAN -->
            <select onchange="filterData()" id="bulan"
                class="px-3 py-1.5 border rounded-md text-sm">

                <option value="">Bulan</option>
                @for($i=1; $i<=12; $i++)
                    <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>

            <!-- TAHUN -->
            <select onchange="filterData()" id="tahun"
                class="px-3 py-1.5 border rounded-md text-sm">

                <option value="">Tahun</option>
                @for($i=2023; $i<=date('Y'); $i++)
                    <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>

            <!-- BUTTON TAMBAH -->
            <a href="/penyuratan/create"
            class="flex items-center gap-2 px-4 py-1.5 bg-blue-500 text-white rounded-md text-sm">
                <span class="text-lg">+</span> Tambah
            </a>

            <a href="/penyuratan/export/pdf"
             class="px-4 py-2 bg-green-500 text-white rounded-md text-sm">
                Export PDF
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

                    <td class="p-4">{{ $s->no_surat }}</td>
                    <td class="p-4">{{ $s->nama_dokumen }}</td>
                    <td class="p-4">{{ $s->jenis->nama_jenis_surat }}</td>
                    <td class="p-4">{{ $s->nama_pengirim_penerima }}</td>
                    <td class="p-4">
                        {{ \Carbon\Carbon::parse($s->tanggal_dokumen)->format('d/m/Y') }}
                    </td>

                    <!-- AKSI -->
                    <td class="p-4">
                        <div class="flex justify-center gap-2">

                            <!-- EDIT -->
                            <a href="/penyuratan/{{ $s->id_dokumen_penyuratan }}/edit"
                                class="bg-green-500 hover:bg-green-600 text-white p-2 rounded">
                                    ✏️
                            </a>

                            <!-- VIEW -->
                            <button onclick="previewFile('{{ asset('storage/'.$s->file_path) }}')"
                                class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded">
                                👁
                            </button>

                            <!-- DELETE -->
                            <form action="/penyuratan/{{ $s->id_dokumen_penyuratan }}" method="POST"
                                onsubmit="return confirm('Yakin hapus data?')">
                                @csrf
                                @method('DELETE')

                                <button class="bg-red-500 hover:bg-red-600 text-white p-2 rounded">
                                    🗑
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
                @endforeach

            </tbody>

        </table>

    </div>

        <div id="previewModal"
         class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

        <div class="bg-white w-3/4 h-3/4 rounded-lg overflow-hidden relative">

            <button onclick="closePreview()"
                    class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded">
                X
            </button>

            <iframe id="previewFrame" class="w-full h-full"></iframe>

        </div>
    </div>

</div>

<div class="p-4 flex justify-between items-center">

    <div class="text-sm text-gray-500">
        Menampilkan {{ $surat->firstItem() }} - {{ $surat->lastItem() }} 
        dari {{ $surat->total() }} data
    </div>

    <div>
        {{ $surat->links() }}
    </div>

</div>

<script>
    function previewFile(url) {
        document.getElementById('previewFrame').src = url;
        document.getElementById('previewModal').classList.remove('hidden');
    }

    function closePreview() {
        document.getElementById('previewModal').classList.add('hidden');
        document.getElementById('previewFrame').src = '';
    }
</script>

<script>
    function filterData() {
        let bulan = document.getElementById('bulan').value;
        let tahun = document.getElementById('tahun').value;

        let url = '/penyuratan?';

        if (bulan) url += 'bulan=' + bulan + '&';
        if (tahun) url += 'tahun=' + tahun + '&';

        window.location.href = url;
    }
</script>

@endsection