@php
    $fileInputId = 'fileInputAdministrasi';
    $fileNameId = 'fileNameAdministrasi';
    $existingFileName = isset($data) && $data?->file_path ? basename($data->file_path) : '';
    $selectedJenisDokumen = old('jenis_dokumen', isset($data) && $data->jenis ? [
        'Absensi Pegawai' => 'absensi_pegawai',
        'Laporan Piket' => 'laporan_piket',
        'Absensi Siswa' => 'absensi_siswa',
        'Jurnal Kelas' => 'jurnal_kelas',
    ][$data->jenis->nama_jenis] ?? null : null);
@endphp

<div class="grid gap-5 md:grid-cols-2">
    <div class="md:col-span-2">
        <label for="nama_dokumen" class="mb-2 block text-base font-medium text-slate-800">Nama Dokumen</label>
        <input id="nama_dokumen"
               type="text"
               name="nama_dokumen"
               value="{{ old('nama_dokumen', $data->nama_dokumen ?? '') }}"
               placeholder="Nama"
               class="w-full rounded-xl border border-blue-100 bg-white px-5 py-4 text-slate-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
               required>
    </div>

    <div class="md:col-span-2">
        <span class="mb-2 block text-base font-medium text-slate-800">Jenis Dokumen</span>
        <div class="flex flex-wrap gap-3">
            @foreach($jenisDokumenOptions as $option)
                <label class="cursor-pointer">
                    <input type="radio"
                           name="jenis_dokumen"
                           value="{{ $option['value'] }}"
                           class="sr-only"
                           {{ $selectedJenisDokumen === $option['value'] ? 'checked' : '' }}
                           required>
                    <span class="jenis-option inline-flex min-w-[180px] items-center justify-center rounded-xl border border-slate-200 px-6 py-3 text-base font-semibold transition {{ $selectedJenisDokumen === $option['value'] ? 'bg-blue-600 text-white border-blue-600 shadow-sm' : 'bg-white text-slate-700 hover:border-blue-300 hover:text-blue-600' }}">
                        {{ $option['label'] }}
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
                   value="{{ old('tanggal_dokumen', isset($data) ? \Illuminate\Support\Carbon::parse($data->tanggal_dokumen)->format('Y-m-d') : '') }}"
                   class="w-full rounded-xl border border-blue-100 bg-white px-5 py-4 pr-12 text-slate-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                   required>
            <i data-feather="calendar" class="pointer-events-none absolute right-4 top-1/2 h-5 w-5 -translate-y-1/2 text-blue-600"></i>
        </div>
    </div>

    <div>
        <label for="di_upload_oleh" class="mb-2 block text-base font-medium text-slate-800">Di-upload oleh</label>
        <input id="di_upload_oleh"
               type="text"
               name="di_upload_oleh"
               value="{{ old('di_upload_oleh', $data->created_by ?? '') }}"
               placeholder="Contoh: Budi"
               class="w-full rounded-xl border border-blue-100 bg-white px-5 py-4 text-slate-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
               required>
    </div>
</div>

<div>
    <label class="mb-2 block text-base font-medium text-slate-800">Upload Surat</label>
    <label for="{{ $fileInputId }}"
           class="flex min-h-[220px] cursor-pointer flex-col items-center justify-center rounded-2xl border border-blue-100 bg-white px-6 py-8 text-center transition hover:border-blue-300 hover:bg-blue-50/40">
        <input id="{{ $fileInputId }}"
               type="file"
               name="file_surat"
               class="hidden"
               accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">

        <span class="inline-flex h-14 w-14 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm">
            <i data-feather="plus" class="h-7 w-7"></i>
        </span>
        <span class="mt-4 text-base font-medium text-slate-700">Klik untuk memilih file surat</span>
        <span class="mt-2 text-sm text-slate-400">Format: pdf, doc, docx, xls, xlsx, jpg, png. Maksimal 2 MB.</span>
        <span id="{{ $fileNameId }}" class="mt-3 text-sm font-semibold text-blue-600">{{ $existingFileName }}</span>
    </label>
</div>

<div class="flex justify-center">
    <button type="submit"
            class="inline-flex min-w-[120px] items-center justify-center rounded-xl bg-blue-600 px-8 py-3 text-xl font-semibold text-white shadow-sm transition hover:bg-blue-700">
        {{ $submitLabel }}
    </button>
</div>

<script>
    (function () {
        const fileInput = document.getElementById(@json($fileInputId));
        const fileName = document.getElementById(@json($fileNameId));
        const jenisInputs = document.querySelectorAll('input[name="jenis_dokumen"]');

        if (fileInput && fileName) {
            fileInput.addEventListener('change', function (event) {
                const file = event.target.files[0];
                fileName.textContent = file ? file.name : '';
            });
        }

        function syncJenisState() {
            jenisInputs.forEach((input) => {
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

        jenisInputs.forEach((input) => {
            input.addEventListener('change', syncJenisState);
        });

        syncJenisState();
    })();
</script>
