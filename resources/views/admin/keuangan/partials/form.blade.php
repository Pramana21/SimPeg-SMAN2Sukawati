@php
    $fileInputId = 'fileInputKeuangan';
    $fileNameId = 'fileNameKeuangan';
    $existingFileName = isset($data) && $data?->file_path ? basename($data->file_path) : '';
@endphp

<div class="space-y-6">
    <div class="grid gap-5 md:grid-cols-2">
        <div class="md:col-span-2">
            <label for="nama_dokumen" class="mb-2 block text-base font-medium text-slate-800">Nama Dokumen</label>
            <input id="nama_dokumen"
                   type="text"
                   name="nama_dokumen"
                   value="{{ old('nama_dokumen', $data->nama_dokumen ?? '') }}"
                   placeholder="Nama"
                   class="w-full rounded-lg border border-blue-100 bg-white px-5 py-4 text-slate-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
        </div>

        <div class="md:col-span-2">
            <label class="mb-2 block text-base font-medium text-slate-800">Jenis Dokumen</label>
            <div class="rounded-lg border border-blue-100 bg-blue-50 px-5 py-4 text-base font-medium text-blue-700">
                {{ $kategori->nama_kategori }}
            </div>
        </div>

        <div>
            <label for="tanggal_dokumen" class="mb-2 block text-base font-medium text-slate-800">Date</label>
            <div class="relative">
                <input id="tanggal_dokumen"
                       type="date"
                       name="tanggal_dokumen"
                       value="{{ old('tanggal_dokumen', isset($data) ? \Illuminate\Support\Carbon::parse($data->tanggal_dokumen)->format('Y-m-d') : '') }}"
                       class="w-full rounded-lg border border-blue-100 bg-white px-5 py-4 pr-12 text-slate-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                <i data-feather="calendar" class="pointer-events-none absolute right-4 top-1/2 h-5 w-5 -translate-y-1/2 text-blue-600"></i>
            </div>
        </div>

        <div>
            <label for="created_by" class="mb-2 block text-base font-medium text-slate-800">Di-upload</label>
            <input id="created_by"
                   type="text"
                   name="created_by"
                   value="{{ old('created_by', $data->created_by ?? '') }}"
                   placeholder="Contoh: Budi"
                   class="w-full rounded-lg border border-blue-100 bg-white px-5 py-4 text-slate-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
        </div>
    </div>

    <div>
        <label class="mb-2 block text-base font-medium text-slate-800">Upload File</label>
        <label for="{{ $fileInputId }}"
               class="flex min-h-[220px] cursor-pointer flex-col items-center justify-center rounded-2xl border border-blue-100 bg-white px-6 py-8 text-center transition hover:border-blue-300 hover:bg-blue-50/40">
            <input id="{{ $fileInputId }}"
                   type="file"
                   name="file"
                   class="hidden"
                   accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">

            <span class="inline-flex h-14 w-14 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm">
                <i data-feather="plus" class="h-7 w-7"></i>
            </span>
            <span class="mt-4 text-base font-medium text-slate-700">Klik untuk memilih file surat</span>
            <span class="mt-2 text-sm text-slate-400">Format: pdf, doc, docx, xls, xlsx, jpg, png.</span>
            <span id="{{ $fileNameId }}" class="mt-3 text-sm font-semibold text-blue-600">{{ $existingFileName }}</span>
        </label>
    </div>

    <div class="flex justify-center">
        <button type="submit"
                class="inline-flex min-w-[120px] items-center justify-center rounded-xl bg-blue-600 px-8 py-3 text-xl font-semibold text-white shadow-sm transition hover:bg-blue-700">
            {{ $submitLabel }}
        </button>
    </div>
</div>

<script>
    (function () {
        const input = document.getElementById(@json($fileInputId));
        const fileName = document.getElementById(@json($fileNameId));

        if (!input || !fileName) {
            return;
        }

        input.addEventListener('change', function (event) {
            const file = event.target.files[0];
            fileName.innerText = file ? file.name : '';
        });
    })();
</script>
