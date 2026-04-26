@extends('layouts.app')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('inventaris.index') }}"
           class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-slate-800 text-slate-800 transition hover:bg-slate-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-4xl font-semibold text-slate-900">Tambah Dokumen</h1>
            <p class="mt-1 text-sm text-slate-500">Lengkapi data inventaris dan unggah file dokumen yang diperlukan.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('inventaris.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid gap-5 md:grid-cols-2">
            <div class="md:col-span-2">
                <label for="nama_dokumen" class="mb-2 block text-base font-medium text-slate-800">Nama Dokumen</label>
                <input id="nama_dokumen"
                       type="text"
                       name="nama_dokumen"
                       value="{{ old('nama_dokumen') }}"
                       placeholder="Nama"
                       class="w-full rounded-xl border border-blue-100 bg-white px-5 py-4 text-slate-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                       required>
            </div>

            <div>
                <label for="tanggal_dokumen" class="mb-2 block text-base font-medium text-slate-800">Date</label>
                <div class="relative">
                    <input id="tanggal_dokumen"
                           type="date"
                           name="tanggal_dokumen"
                           value="{{ old('tanggal_dokumen') }}"
                           class="w-full rounded-xl border border-blue-100 bg-white px-5 py-4 pr-12 text-slate-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                           required>
                    <i data-feather="calendar" class="pointer-events-none absolute right-4 top-1/2 h-5 w-5 -translate-y-1/2 text-blue-600"></i>
                </div>
            </div>

            <div>
                <label for="created_by" class="mb-2 block text-base font-medium text-slate-800">Di-upload</label>
                <input id="created_by"
                       type="text"
                       name="created_by"
                       value="{{ old('created_by') }}"
                       placeholder="Contoh: Budi"
                       class="w-full rounded-xl border border-blue-100 bg-white px-5 py-4 text-slate-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
            </div>
        </div>

        <div>
            <label class="mb-2 block text-base font-medium text-slate-800">Upload Surat</label>
            <label for="file_surat"
                   class="flex min-h-[220px] cursor-pointer flex-col items-center justify-center rounded-2xl border border-blue-100 bg-white px-6 py-8 text-center transition hover:border-blue-300 hover:bg-blue-50/40">
                <input id="file_surat"
                       type="file"
                       name="file_surat"
                       class="hidden"
                       accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                       required>

                <span class="inline-flex h-14 w-14 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </span>
                <span class="mt-4 text-base font-medium text-slate-700">Klik untuk memilih file inventaris</span>
                <span class="mt-2 text-sm text-slate-400">Format: pdf, doc, docx, xls, xlsx, jpg, png. Maksimal 5 MB.</span>
                <span id="file-name" class="mt-3 text-sm font-semibold text-blue-600"></span>
            </label>
        </div>

        <div class="flex justify-center">
            <button type="submit"
                    class="inline-flex min-w-[120px] items-center justify-center rounded-xl bg-blue-600 px-8 py-3 text-xl font-semibold text-white shadow-sm transition hover:bg-blue-700">
                Upload
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('file_surat').addEventListener('change', function (event) {
        const fileName = event.target.files[0] ? event.target.files[0].name : '';
        document.getElementById('file-name').textContent = fileName;
    });
</script>
@endsection
