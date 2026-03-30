@extends('layouts.app')

@section('content')
@php
    $selectedKelas = request('kelas');
    $selectedKategori = request('kategori');
    $selectedNomorKelas = request('nomor_kelas');

    $resolveTingkat = function ($item) {
        $kelas = $item->kelas;

        if (in_array($kelas, ['X', 'XI', 'XII'], true)) {
            return $kelas;
        }

        return null;
    };

    $resolveKategori = function ($item) {
        if (!$item->kategori_kelas) {
            return null;
        }

        if (preg_match('/^([A-Z])\s*-\s*(\d+)$/', $item->kategori_kelas, $matches)) {
            return [
                'prefix' => $matches[1],
                'nomor' => $matches[2],
                'label' => $matches[1] . ' - ' . $matches[2],
            ];
        }

        return [
            'prefix' => null,
            'nomor' => null,
            'label' => $item->kategori_kelas,
        ];
    };

    $resolveKelasLabel = function ($item) use ($resolveTingkat) {
        $tingkat = $resolveTingkat($item);

        if (in_array($tingkat, ['X', 'XI', 'XII'], true)) {
            return 'Kelas ' . $tingkat;
        }

        return '-';
    };

    $filteredData = $data->filter(function ($item) use ($selectedKelas, $selectedKategori, $selectedNomorKelas, $resolveTingkat, $resolveKategori) {
        $tingkat = $resolveTingkat($item);
        $kategori = $resolveKategori($item);

        $matchKelas = blank($selectedKelas) || $tingkat === $selectedKelas;
        $matchKategori = blank($selectedKategori) || (($kategori['prefix'] ?? null) === $selectedKategori);
        $matchNomorKelas = blank($selectedNomorKelas) || (($kategori['nomor'] ?? null) === $selectedNomorKelas);

        return $matchKelas && $matchKategori && $matchNomorKelas;
    })->values();
@endphp

<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('data-center.index') }}"
           class="inline-flex h-14 w-14 items-center justify-center rounded-full border-2 border-slate-900 text-slate-900 transition hover:bg-slate-900 hover:text-white">
            <i data-feather="arrow-left" class="h-7 w-7"></i>
        </a>
        <div>
            <h1 class="text-4xl font-semibold text-slate-900">Data Murid</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola data siswa dengan tampilan, filter, dan aksi yang konsisten dengan modul lain.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="rounded-[28px] border border-slate-200 bg-white/90 p-5 shadow-sm">
        <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
            <form method="GET" class="flex flex-wrap items-center gap-3">
                <div class="relative">
                    <select name="kelas"
                            class="min-w-[150px] appearance-none rounded-lg border border-slate-200 bg-white px-4 py-2.5 pr-10 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                        <option value="">Semua Kelas</option>
                        <option value="X" {{ $selectedKelas === 'X' ? 'selected' : '' }}>Kelas X</option>
                        <option value="XI" {{ $selectedKelas === 'XI' ? 'selected' : '' }}>Kelas XI</option>
                        <option value="XII" {{ $selectedKelas === 'XII' ? 'selected' : '' }}>Kelas XII</option>
                    </select>
                    <i data-feather="chevron-down" class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                </div>

                <div class="relative">
                    <select name="kategori"
                            class="min-w-[170px] appearance-none rounded-lg border border-slate-200 bg-white px-4 py-2.5 pr-10 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                        <option value="">Semua Kategori</option>
                        <option value="E" {{ $selectedKategori === 'E' ? 'selected' : '' }}>Kelas E (X)</option>
                        <option value="F" {{ $selectedKategori === 'F' ? 'selected' : '' }}>Kelas F (XI & XII)</option>
                    </select>
                    <i data-feather="chevron-down" class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                </div>

                <div class="relative">
                    <select name="nomor_kelas"
                            id="nomorKelasFilter"
                            class="min-w-[150px] appearance-none rounded-lg border border-slate-200 bg-white px-4 py-2.5 pr-10 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                        <option value="">Semua Nomor</option>
                        @for($nomor = 1; $nomor <= 10; $nomor++)
                            <option value="{{ $nomor }}" {{ (string) $selectedNomorKelas === (string) $nomor ? 'selected' : '' }}>
                                {{ ($selectedKelas === 'X' ? 'E' : (($selectedKelas === 'XI' || $selectedKelas === 'XII') ? 'F' : 'Kategori')) . ' - ' . $nomor }}
                            </option>
                        @endfor
                    </select>
                    <i data-feather="chevron-down" class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                </div>

                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                    <i data-feather="filter" class="h-4 w-4"></i>
                    Filter
                </button>

                @if($selectedKelas || $selectedKategori || $selectedNomorKelas)
                    <a href="{{ route('murid.index') }}"
                       class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-800">
                        Reset
                    </a>
                @endif
            </form>

            <a href="{{ route('murid.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                <span class="text-lg leading-none">+</span>
                Tambah
            </a>
        </div>

        <div class="mt-5 overflow-hidden rounded-[24px] border border-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-700">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-4 text-left font-semibold text-slate-800">
                                <input type="checkbox" class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            </th>
                            <th class="px-4 py-4 text-left font-semibold text-slate-800">NIS</th>
                            <th class="px-4 py-4 text-left font-semibold text-slate-800">Nama</th>
                            <th class="px-4 py-4 text-left font-semibold text-slate-800">Kelas</th>
                            <th class="px-4 py-4 text-left font-semibold text-slate-800">Kategori</th>
                            <th class="px-4 py-4 text-left font-semibold text-slate-800">Gender</th>
                            <th class="px-4 py-4 text-left font-semibold text-slate-800">Phone</th>
                            <th class="px-4 py-4 text-center font-semibold text-slate-800">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($filteredData as $item)
                            <tr class="transition hover:bg-slate-50">
                                <td class="px-4 py-4">
                                    <input type="checkbox" class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                </td>
                                <td class="px-4 py-4 font-medium text-slate-900">{{ $item->nis }}</td>
                                <td class="px-4 py-4">
                                    <div class="font-medium text-slate-900">{{ $item->nama_siswa }}</div>
                                    <div class="text-xs text-slate-500">{{ $item->email ?: '-' }}</div>
                                </td>
                                <td class="px-4 py-4">{{ $resolveKelasLabel($item) }}</td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                        {{ $resolveKategori($item)['label'] ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">{{ $item->jenis_kelamin ?: '-' }}</td>
                                <td class="px-4 py-4">{{ $item->no_hp ?: '-' }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('murid.edit', $item->id_siswa) }}"
                                           class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-green-500 p-2 text-white transition hover:opacity-90"
                                           title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M17.414 2.586a2 2 0 010 2.828l-8.5 8.5a2 2 0 01-.878.497l-3 1a1 1 0 01-1.265-1.265l1-3a2 2 0 01.497-.878l8.5-8.5a2 2 0 012.828 0zm-9.62 8.206L5.91 12.676l-.38 1.14 1.14-.38 1.884-1.883-1.06-1.061z"/>
                                            </svg>
                                        </a>

                                        <a href="{{ route('murid.show', $item->id_siswa) }}"
                                           class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-blue-500 p-2 text-white transition hover:opacity-90"
                                           title="Preview">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M10 3C5.455 3 1.73 6.11.458 10c1.272 3.89 4.997 7 9.542 7s8.27-3.11 9.542-7C18.27 6.11 14.545 3 10 3zm0 11a4 4 0 110-8 4 4 0 010 8z"/>
                                                <path d="M10 8a2 2 0 100 4 2 2 0 000-4z"/>
                                            </svg>
                                        </a>

                                        <form action="{{ route('murid.destroy', $item->id_siswa) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-red-500 p-2 text-white transition hover:opacity-90"
                                                    title="Delete">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M6 4a2 2 0 012-2h4a2 2 0 012 2h3a1 1 0 110 2h-1v9a2 2 0 01-2 2H6a2 2 0 01-2-2V6H3a1 1 0 010-2h3zm2-1a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1H8zm-1 5a1 1 0 012 0v6a1 1 0 11-2 0V8zm4-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-12 text-center text-sm text-slate-500">
                                    Data murid belum tersedia untuk filter yang dipilih.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 flex flex-col gap-3 text-sm text-slate-500 lg:flex-row lg:items-center lg:justify-between">
            <div>
                Menampilkan {{ $filteredData->count() }} dari {{ $data->count() }} data murid
            </div>
            <div>Panjang per halaman semua data</div>
        </div>
    </div>
</div>
<script>
    (function () {
        const kelasFilter = document.querySelector('select[name="kelas"]');
        const kategoriFilter = document.querySelector('select[name="kategori"]');
        const nomorFilter = document.getElementById('nomorKelasFilter');

        function syncKategoriFilter() {
            if (!kelasFilter || !kategoriFilter) {
                return;
            }

            if (kelasFilter.value === 'X') {
                kategoriFilter.value = 'E';
            } else if (kelasFilter.value === 'XI' || kelasFilter.value === 'XII') {
                kategoriFilter.value = 'F';
            }
        }

        function syncNomorLabels() {
            if (!kelasFilter || !nomorFilter) {
                return;
            }

            const prefix = kelasFilter.value === 'X' ? 'E' : ((kelasFilter.value === 'XI' || kelasFilter.value === 'XII') ? 'F' : 'Kategori');

            Array.from(nomorFilter.options).forEach((option, index) => {
                if (index === 0) {
                    option.textContent = 'Semua Nomor';
                    return;
                }

                option.textContent = `${prefix} - ${option.value}`;
            });
        }

        if (kelasFilter) {
            kelasFilter.addEventListener('change', function () {
                syncKategoriFilter();
                syncNomorLabels();
            });
        }

        syncNomorLabels();
    })();
</script>
@endsection
