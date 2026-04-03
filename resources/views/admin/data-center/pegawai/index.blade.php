@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('data-center.index') }}"
           class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-slate-800 text-slate-800 transition hover:bg-slate-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-4xl font-semibold text-slate-900">Staff / Guru</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola data pegawai dan guru dengan pola tabel dan aksi yang konsisten di seluruh sistem.</p>
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
            <div>
                <h2 class="text-lg font-semibold text-slate-900">Daftar Pegawai</h2>
                <p class="mt-1 text-sm text-slate-500">Data staff dan guru aktif tersusun rapi dengan aksi cepat yang seragam.</p>
            </div>

            <a href="{{ route('pegawai.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah
            </a>
        </div>

        <div class="mt-5 overflow-hidden rounded-[24px] border border-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-700">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-4 text-left font-semibold text-slate-800">
                                <input type="checkbox" id="selectAllPegawai" class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            </th>
                            <th class="px-4 py-4 text-left font-semibold text-slate-800">NIP</th>
                            <th class="px-4 py-4 text-left font-semibold text-slate-800">Nama</th>
                            <th class="px-4 py-4 text-left font-semibold text-slate-800">Status</th>
                            <th class="px-4 py-4 text-left font-semibold text-slate-800">Gender</th>
                            <th class="px-4 py-4 text-left font-semibold text-slate-800">Phone</th>
                            <th class="px-4 py-4 text-center font-semibold text-slate-800">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($data as $item)
                            <tr class="transition hover:bg-slate-50">
                                <td class="px-4 py-4">
                                    <input type="checkbox" name="selected_ids[]" value="{{ $item->id_pegawai }}" class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                </td>
                                <td class="px-4 py-4 font-medium text-slate-900">{{ $item->nip_nippk ?: '-' }}</td>
                                <td class="px-4 py-4">
                                    <div class="font-medium text-slate-900">{{ $item->nama_pegawai }}</div>
                                    <div class="text-xs text-slate-500">{{ $item->email ?: '-' }}</div>
                                </td>
                                <td class="px-4 py-4">{{ $item->status_pegawai ?: '-' }}</td>
                                <td class="px-4 py-4">{{ $item->jenis_kelamin ?: '-' }}</td>
                                <td class="px-4 py-4">{{ $item->no_hp ?: '-' }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('pegawai.edit', $item->id_pegawai) }}"
                                           class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-green-500 p-2 text-white transition hover:opacity-90"
                                           title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M17.414 2.586a2 2 0 010 2.828l-8.5 8.5a2 2 0 01-.878.497l-3 1a1 1 0 01-1.265-1.265l1-3a2 2 0 01.497-.878l8.5-8.5a2 2 0 012.828 0zm-9.62 8.206L5.91 12.676l-.38 1.14 1.14-.38 1.884-1.883-1.06-1.061z"/>
                                            </svg>
                                        </a>

                                        <a href="{{ route('pegawai.show', $item->id_pegawai) }}"
                                           class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-blue-500 p-2 text-white transition hover:opacity-90"
                                           title="Preview">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M10 3C5.455 3 1.73 6.11.458 10c1.272 3.89 4.997 7 9.542 7s8.27-3.11 9.542-7C18.27 6.11 14.545 3 10 3zm0 11a4 4 0 110-8 4 4 0 010 8z"/>
                                                <path d="M10 8a2 2 0 100 4 2 2 0 000-4z"/>
                                            </svg>
                                        </a>

                                        <form action="{{ route('pegawai.destroy', $item->id_pegawai) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data?')">
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
                                <td colspan="7" class="px-4 py-12 text-center text-sm text-slate-500">
                                    Data pegawai belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 flex flex-col gap-3 text-sm text-slate-500 lg:flex-row lg:items-center lg:justify-between">
            <div>Menampilkan {{ $data->count() }} data pegawai</div>
            <div>Panjang per halaman semua data</div>
        </div>
    </div>
</div>
<script>
    (function () {
        const selectAll = document.getElementById('selectAllPegawai');

        if (!selectAll) {
            return;
        }

        selectAll.onclick = function () {
            document.querySelectorAll('input[name="selected_ids[]"]').forEach((cb) => {
                cb.checked = this.checked;
            });
        };
    })();
</script>
@endsection
