@extends('layouts.app')

@section('content')
@php
    $query = request()->query();
    $allQuery = collect($query)->except('jenis')->filter(fn ($value) => $value !== null && $value !== '')->all();
    $masukQuery = array_merge($allQuery, ['jenis' => 'masuk']);
    $keluarQuery = array_merge($allQuery, ['jenis' => 'keluar']);
@endphp

<div class="space-y-6">
    <div>
        <h1 class="text-4xl font-semibold text-slate-900">Penyuratan</h1>
        <p class="mt-2 text-sm text-slate-500">Kelola surat masuk dan keluar dengan filter yang tetap sinkron ke tabel dan pagination.</p>
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
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('penyuratan.index', $allQuery) }}"
                   class="inline-flex items-center rounded-lg px-5 py-2.5 text-sm font-semibold transition {{ $selectedJenis === '' ? 'bg-blue-600 text-white shadow-sm' : 'bg-blue-500 text-white hover:bg-blue-600' }}">
                    All
                </a>
                <a href="{{ route('penyuratan.index', $masukQuery) }}"
                   class="inline-flex items-center rounded-lg px-5 py-2.5 text-sm font-semibold transition {{ $selectedJenis === 'masuk' ? 'bg-blue-600 text-white shadow-sm' : 'bg-blue-500 text-white hover:bg-blue-600' }}">
                    Masuk
                </a>
                <a href="{{ route('penyuratan.index', $keluarQuery) }}"
                   class="inline-flex items-center rounded-lg px-5 py-2.5 text-sm font-semibold transition {{ $selectedJenis === 'keluar' ? 'bg-blue-600 text-white shadow-sm' : 'bg-blue-500 text-white hover:bg-blue-600' }}">
                    Keluar
                </a>
            </div>

            <div class="flex flex-wrap items-center gap-3 xl:justify-end">
                <form id="bulkDeletePenyuratanForm" action="{{ route('penyuratan.bulk-delete') }}" method="POST" class="hidden">
                    @csrf
                </form>

                <button type="button"
                        id="bulkDeletePenyuratanButton"
                        class="inline-flex items-center gap-2 rounded-lg bg-red-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M6 4a2 2 0 012-2h4a2 2 0 012 2h3a1 1 0 110 2h-1v9a2 2 0 01-2 2H6a2 2 0 01-2-2V6H3a1 1 0 010-2h3zm2-1a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1H8zm-1 5a1 1 0 012 0v6a1 1 0 11-2 0V8zm4-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    Hapus Terpilih
                </button>

                <form method="GET" action="{{ route('penyuratan.index') }}" class="flex flex-wrap items-center gap-3">
                    @if($selectedJenis !== '')
                        <input type="hidden" name="jenis" value="{{ $selectedJenis }}">
                    @endif

                    <div class="relative">
                        <select name="bulan"
                                onchange="this.form.submit()"
                                class="min-w-[150px] appearance-none rounded-lg border border-blue-200 bg-blue-500 px-4 py-2.5 pr-10 text-sm font-semibold text-white outline-none transition hover:bg-blue-600">
                            <option value="">Pilih bulan</option>
                            @foreach($months as $monthValue => $monthLabel)
                                <option value="{{ $monthValue }}" {{ $selectedBulan === $monthValue ? 'selected' : '' }}>
                                    {{ $monthLabel }}
                                </option>
                            @endforeach
                        </select>
                        <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </div>

                    <div class="relative">
                        <select name="tahun"
                                onchange="this.form.submit()"
                                class="min-w-[120px] appearance-none rounded-lg border border-blue-200 bg-blue-500 px-4 py-2.5 pr-10 text-sm font-semibold text-white outline-none transition hover:bg-blue-600">
                            <option value="">Tahun</option>
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ $selectedTahun === $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                        <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </div>
                </form>

                <a href="{{ route('penyuratan.create') }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah
                </a>

                @if($selectedBulan || $selectedTahun || $selectedJenis !== '')
                    <a href="{{ route('penyuratan.index') }}"
                       class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-800">
                        Reset
                    </a>
                @endif
            </div>
        </div>

        <div class="mt-5 overflow-hidden rounded-[24px] border border-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-700">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-4 text-left font-semibold text-slate-800">
                                <input type="checkbox" id="selectAllPenyuratan" class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            </th>
                            <th class="px-4 py-4 text-left font-semibold text-slate-800">No Surat</th>
                            <th class="px-4 py-4 text-left font-semibold text-slate-800">Nama Surat</th>
                            <th class="px-4 py-4 text-left font-semibold text-slate-800">Jenis Surat</th>
                            <th class="px-4 py-4 text-left font-semibold text-slate-800">Pengirim/Penerima</th>
                            <th class="px-4 py-4 text-left font-semibold text-slate-800">Dibuat Oleh</th>
                            <th class="px-4 py-4 text-left font-semibold text-slate-800">Tanggal</th>
                            <th class="px-4 py-4 text-center font-semibold text-slate-800">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse($surat as $item)
                            <tr class="transition hover:bg-slate-50">
                                <td class="px-4 py-4 align-top">
                                    <input type="checkbox"
                                           value="{{ $item->id_dokumen_penyuratan }}"
                                           class="row-checkbox-penyuratan h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                </td>
                                <td class="px-4 py-4 font-medium text-slate-900">{{ $item->no_surat }}</td>
                                <td class="px-4 py-4">{{ $item->nama_dokumen }}</td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ strtolower($item->jenis->nama_jenis_surat ?? '') === 'masuk' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ $item->jenis->nama_jenis_surat ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">{{ $item->nama_pengirim_penerima }}</td>
                                <td class="px-4 py-4">{{ $item->created_by }}</td>
                                <td class="px-4 py-4">{{ \Illuminate\Support\Carbon::parse($item->tanggal_dokumen)->format('d/m/Y') }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('penyuratan.edit', $item->id_dokumen_penyuratan) }}"
                                           class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-green-500 px-2 py-1 text-white transition hover:bg-green-600"
                                           title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M17.414 2.586a2 2 0 010 2.828l-8.5 8.5a2 2 0 01-.878.497l-3 1a1 1 0 01-1.265-1.265l1-3a2 2 0 01.497-.878l8.5-8.5a2 2 0 012.828 0zm-9.62 8.206L5.91 12.676l-.38 1.14 1.14-.38 1.884-1.883-1.06-1.061z"/>
                                            </svg>
                                        </a>

                                        <a href="{{ route('penyuratan.show', $item->id_dokumen_penyuratan) }}"
                                           class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-blue-500 px-2 py-1 text-white transition hover:bg-blue-600"
                                           title="Preview">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M10 3C5.455 3 1.73 6.11.458 10c1.272 3.89 4.997 7 9.542 7s8.27-3.11 9.542-7C18.27 6.11 14.545 3 10 3zm0 11a4 4 0 110-8 4 4 0 010 8z"/>
                                                <path d="M10 8a2 2 0 100 4 2 2 0 000-4z"/>
                                            </svg>
                                        </a>

                                        <form action="{{ route('penyuratan.destroy', $item->id_dokumen_penyuratan) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus surat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-red-500 px-2 py-1 text-white transition hover:bg-red-600"
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
                                    Data surat belum tersedia untuk filter yang dipilih.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 flex flex-col gap-3 text-sm text-slate-500 lg:flex-row lg:items-center lg:justify-between">
            <div>
                @if($surat->count())
                    Menampilkan {{ $surat->firstItem() }} - {{ $surat->lastItem() }} dari {{ $surat->total() }} data
                @else
                    Menampilkan 0 data
                @endif
            </div>

            <div class="flex items-center gap-4">
                <div>Panjang per halaman 10</div>
                <div>
                    {{ $surat->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const bulkDeletePenyuratanForm = document.getElementById('bulkDeletePenyuratanForm');
    const bulkDeletePenyuratanButton = document.getElementById('bulkDeletePenyuratanButton');
    const selectAllPenyuratan = document.getElementById('selectAllPenyuratan');
    const penyuratanCheckboxes = Array.from(document.querySelectorAll('.row-checkbox-penyuratan'));

    function syncPenyuratanHeaderCheckbox() {
        if (!selectAllPenyuratan) {
            return;
        }

        const checkedCount = penyuratanCheckboxes.filter((checkbox) => checkbox.checked).length;
        selectAllPenyuratan.checked = penyuratanCheckboxes.length > 0 && checkedCount === penyuratanCheckboxes.length;
        selectAllPenyuratan.indeterminate = checkedCount > 0 && checkedCount < penyuratanCheckboxes.length;
    }

    if (selectAllPenyuratan) {
        selectAllPenyuratan.addEventListener('change', function () {
            penyuratanCheckboxes.forEach((checkbox) => {
                checkbox.checked = this.checked;
            });

            syncPenyuratanHeaderCheckbox();
        });
    }

    penyuratanCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', syncPenyuratanHeaderCheckbox);
    });

    if (bulkDeletePenyuratanButton) {
        bulkDeletePenyuratanButton.addEventListener('click', function () {
            const selectedIds = penyuratanCheckboxes
                .filter((checkbox) => checkbox.checked)
                .map((checkbox) => checkbox.value);

            if (selectedIds.length === 0) {
                alert('Pilih minimal satu data surat untuk dihapus.');
                return;
            }

            if (!confirm('Yakin ingin menghapus semua data surat yang dipilih?')) {
                return;
            }

            bulkDeletePenyuratanForm.querySelectorAll('input[name="ids[]"]').forEach((input) => input.remove());

            selectedIds.forEach((id) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = id;
                bulkDeletePenyuratanForm.appendChild(input);
            });

            bulkDeletePenyuratanForm.submit();
        });
    }
</script>
@endsection
