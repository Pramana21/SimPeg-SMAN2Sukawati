@extends('layouts.app')

@section('content')
@php
    $defaultJenis = old('jenis_surat', 'masuk');
@endphp

<div class="max-w-4xl space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('penyuratan.index') }}"
           class="inline-flex h-14 w-14 items-center justify-center rounded-full border-2 border-slate-900 text-slate-900 transition hover:bg-slate-900 hover:text-white">
            <i data-feather="arrow-left" class="h-7 w-7"></i>
        </a>
        <div>
            <h1 class="text-4xl font-semibold text-slate-900">Tambah Surat</h1>
            <p class="mt-1 text-sm text-slate-500">Lengkapi seluruh field wajib sebelum menyimpan dokumen penyuratan.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('penyuratan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid gap-5 md:grid-cols-2">
            <div class="md:col-span-2">
                <label for="no_surat" class="mb-2 block text-base font-medium text-slate-800">No Surat</label>
                <input id="no_surat"
                       type="text"
                       name="no_surat"
                       value="{{ old('no_surat') }}"
                       placeholder="No Surat"
                       class="w-full rounded-xl border border-blue-100 bg-white px-5 py-4 text-slate-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                       required>
            </div>

            <div class="md:col-span-2">
                <label for="nama_dokumen" class="mb-2 block text-base font-medium text-slate-800">Perihal</label>
                <input id="nama_dokumen"
                       type="text"
                       name="nama_dokumen"
                       value="{{ old('nama_dokumen') }}"
                       placeholder="Nama"
                       class="w-full rounded-xl border border-blue-100 bg-white px-5 py-4 text-slate-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                       required>
            </div>

            <div class="md:col-span-2">
                <span class="mb-2 block text-base font-medium text-slate-800">Jenis Surat (Masuk/Keluar)</span>
                <div class="flex flex-wrap gap-3" id="jenis-surat-group">
                    @foreach(['masuk' => 'Masuk', 'keluar' => 'Keluar'] as $value => $label)
                        @php $checked = $defaultJenis === $value; @endphp
                        <label class="cursor-pointer" data-radio-option>
                            <input type="radio"
                                   name="jenis_surat"
                                   value="{{ $value }}"
                                   class="sr-only"
                                   {{ $checked ? 'checked' : '' }}
                                   required>
                            <span class="inline-flex min-w-[140px] items-center justify-center rounded-xl border border-slate-200 px-6 py-3 text-base font-semibold transition {{ $checked ? 'bg-blue-600 text-white border-blue-600 shadow-sm' : 'bg-white text-slate-700 hover:border-blue-300 hover:text-blue-600' }}">
                                {{ $label }}
                            </span>
                        </label>
                    @endforeach
                </div>
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
                <label for="nama_pengirim_penerima" class="mb-2 block text-base font-medium text-slate-800">Nama Pengirim/Penerima</label>
                <input id="nama_pengirim_penerima"
                       type="text"
                       name="nama_pengirim_penerima"
                       value="{{ old('nama_pengirim_penerima') }}"
                       placeholder="Contoh: Budi"
                       class="w-full rounded-xl border border-blue-100 bg-white px-5 py-4 text-slate-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                       required>
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
                    <i data-feather="plus" class="h-7 w-7"></i>
                </span>
                <span class="mt-4 text-base font-medium text-slate-700">Klik untuk memilih file surat</span>
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

    const jenisSuratInputs = document.querySelectorAll('input[name="jenis_surat"]');

    function syncJenisSuratState() {
        jenisSuratInputs.forEach((input) => {
            const button = input.nextElementSibling;

            if (!button) {
                return;
            }

            if (input.checked) {
                button.classList.add('bg-blue-600', 'text-white', 'border-blue-600', 'shadow-sm');
                button.classList.remove('bg-white', 'text-slate-700', 'hover:border-blue-300', 'hover:text-blue-600');
            } else {
                button.classList.remove('bg-blue-600', 'text-white', 'border-blue-600', 'shadow-sm');
                button.classList.add('bg-white', 'text-slate-700', 'hover:border-blue-300', 'hover:text-blue-600');
            }
        });
    }

    jenisSuratInputs.forEach((input) => {
        input.addEventListener('change', syncJenisSuratState);
    });

    syncJenisSuratState();
</script>
@endsection
