@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-4xl font-semibold text-slate-900">Audit Log</h1>
        <p class="mt-2 text-sm text-slate-500">Catatan aktivitas pengguna di sistem untuk memantau perubahan data terbaru.</p>
    </div>

    <div class="rounded-[28px] border border-slate-200 bg-white/90 p-5 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <form method="GET" action="{{ url('/audit-log') }}" class="flex gap-3 items-center">
                <div class="relative">
                    <select name="bulan"
                            class="min-w-[170px] appearance-none rounded-lg border border-blue-200 bg-blue-500 px-4 py-2.5 pr-10 text-sm font-semibold text-white outline-none transition hover:bg-blue-600">
                        <option value="">Semua Bulan</option>
                        @foreach($months as $monthValue => $monthLabel)
                            <option value="{{ $monthValue }}" {{ $selectedBulan === $monthValue ? 'selected' : '' }}>
                                {{ $monthLabel }}
                            </option>
                        @endforeach
                    </select>
                    <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </div>

                <div class="relative">
                    <select name="tahun"
                            class="min-w-[140px] appearance-none rounded-lg border border-blue-200 bg-blue-500 px-4 py-2.5 pr-10 text-sm font-semibold text-white outline-none transition hover:bg-blue-600">
                        <option value="">Semua Tahun</option>
                        @foreach($years as $year)
                            <option value="{{ $year }}" {{ $selectedTahun === $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                    <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </div>

                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2l-7 7v5l-4-2v-3L3 6V4z" />
                    </svg>
                    <span>Filter</span>
                </button>
            </form>

            @can('audit_log.delete')
                <div class="flex items-center">
                    <button type="submit"
                            id="deleteSelectedButton"
                            form="auditLogBulkDeleteForm"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus data yang dipilih?')"
                            class="self-center inline-flex items-center gap-2 rounded-lg bg-red-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 7h12M9 7V4h6v3m-7 0v13m4-13v13m4-13v13M5 7h14" />
                        </svg>
                        <span>Hapus</span>
                    </button>
                </div>
            @endcan
        </div>

        <form method="POST" action="{{ route('audit-log.bulk-delete') }}" id="auditLogBulkDeleteForm">
            @csrf
            @method('DELETE')

            <div class="overflow-hidden rounded-[24px] border border-slate-200">
                <div class="border-b border-slate-200 bg-white px-5 py-4">
                    <h2 class="text-[2rem] font-semibold leading-none text-slate-900">Aktivitas Terakhir (Audit Log)</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-700">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-4 text-left font-semibold text-slate-800">
                                    @can('audit_log.delete')
                                        <input type="checkbox" id="checkAll" class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                    @endcan
                                </th>
                                <th class="px-4 py-4 text-left font-semibold text-slate-800">Waktu</th>
                                <th class="px-4 py-4 text-left font-semibold text-slate-800">Pengguna</th>
                                <th class="px-4 py-4 text-left font-semibold text-slate-800">Modul</th>
                                <th class="px-4 py-4 text-left font-semibold text-slate-800">Aktivitas</th>
                                <th class="px-4 py-4 text-left font-semibold text-slate-800">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @forelse($logs as $log)
                                <tr class="transition hover:bg-slate-50">
                                    <td class="px-4 py-4 align-top">
                                        @can('audit_log.delete')
                                            <input type="checkbox"
                                                   name="selected_ids[]"
                                                   value="{{ $log->id }}"
                                                   class="rowCheckbox h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                        @endcan
                                    </td>
                                    <td class="px-4 py-4 font-medium text-slate-900">{{ $log->created_at?->timezone('Asia/Makassar')->format('d-m-Y H:i') ?? '-' }}</td>
                                    <td class="px-4 py-4">{{ $log->user?->pegawai?->nama_pegawai ?? $log->user?->username ?? $log->nama_pengguna ?? '-' }}</td>
                                    <td class="px-4 py-4">{{ $log->modul }}</td>
                                    <td class="px-4 py-4">{{ $log->aktivitas }}</td>
                                    <td class="px-4 py-4">{{ $log->keterangan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-12 text-center text-sm text-slate-500">
                                        Belum ada data audit log untuk filter yang dipilih.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-slate-200 bg-white px-5 py-4">
                    <div class="flex flex-col gap-3 text-sm text-slate-500 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            @if($logs->count())
                                Menampilkan {{ $logs->firstItem() }} - {{ $logs->lastItem() }} dari {{ $logs->total() }} data
                            @else
                                Menampilkan 0 data
                            @endif
                        </div>

                        <div class="flex items-center gap-4">
                            <div>Panjang per halaman 10</div>
                            <div>{{ $logs->onEachSide(1)->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const checkAll = document.getElementById('checkAll');
    const rowCheckboxes = Array.from(document.querySelectorAll('.rowCheckbox'));
    const deleteSelectedButton = document.getElementById('deleteSelectedButton');

    function syncHeaderCheckbox() {
        if (!checkAll) {
            return;
        }

        const checkedCount = rowCheckboxes.filter((checkbox) => checkbox.checked).length;
        checkAll.checked = rowCheckboxes.length > 0 && checkedCount === rowCheckboxes.length;
        checkAll.indeterminate = checkedCount > 0 && checkedCount < rowCheckboxes.length;
    }

    if (checkAll) {
        checkAll.addEventListener('change', function () {
            rowCheckboxes.forEach((checkbox) => {
                checkbox.checked = this.checked;
            });

            syncHeaderCheckbox();
        });
    }

    rowCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', syncHeaderCheckbox);
    });

    if (deleteSelectedButton) {
        deleteSelectedButton.addEventListener('click', function (event) {
            const checkedCount = rowCheckboxes.filter((checkbox) => checkbox.checked).length;

            if (checkedCount === 0) {
                event.preventDefault();
                alert('Pilih minimal satu data audit log.');
                return;
            }
        });
    }
</script>
@endsection
