@php
    $fileInputId = 'fileInputAdministrasi';
    $fileNameId = 'fileNameAdministrasi';
    $existingFileName = isset($data) && $data?->file_path ? basename($data->file_path) : '';
    $existingFileUrl = isset($data) && $data?->file_path ? asset('storage/' . $data->file_path) : null;
    $showClassFields = $showClassFields ?? false;
    $selectedNomorKelas = old('nomor_kelas');

    if (!$selectedNomorKelas && isset($data) && !empty($data->kategori_kelas)) {
        preg_match('/(\d+)$/', $data->kategori_kelas, $matches);
        $selectedNomorKelas = $matches[1] ?? null;
    }

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

    @if($showClassFields)
        <div>
            <label for="kelas" class="mb-2 block text-base font-medium text-slate-800">Kelas</label>
            <select id="kelas"
                    name="kelas"
                    class="w-full rounded-xl border border-blue-100 bg-white px-5 py-4 text-slate-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    required>
                <option value="">-- Pilih Kelas --</option>
                <option value="X" {{ old('kelas', $data->kelas ?? '') === 'X' ? 'selected' : '' }}>X</option>
                <option value="XI" {{ old('kelas', $data->kelas ?? '') === 'XI' ? 'selected' : '' }}>XI</option>
                <option value="XII" {{ old('kelas', $data->kelas ?? '') === 'XII' ? 'selected' : '' }}>XII</option>
            </select>
        </div>

        <div>
            <label for="kategori_kelas" class="mb-2 block text-base font-medium text-slate-800">Kategori Kelas</label>
            <select id="kategori_kelas"
                    name="nomor_kelas"
                    class="w-full rounded-xl border border-blue-100 bg-white px-5 py-4 text-slate-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    required>
                <option value="">-- Pilih Kategori Kelas --</option>
            </select>
        </div>
    @endif

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
            <span class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10m-12 9h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z"/>
                </svg>
            </span>
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
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
        </span>
        <span class="mt-4 text-base font-medium text-slate-700">Klik untuk memilih file surat</span>
        <span class="mt-2 text-sm text-slate-400">Format: pdf, doc, docx, xls, xlsx, jpg, png. Maksimal 2 MB.</span>
        <span id="{{ $fileNameId }}" class="mt-3 text-sm font-semibold text-blue-600">{{ $existingFileName }}</span>

        @if($existingFileUrl)
            <a href="{{ $existingFileUrl }}"
               target="_blank"
               rel="noopener noreferrer"
               class="mt-2 text-sm font-medium text-blue-600 underline-offset-2 hover:underline">
                Lihat File Saat Ini
            </a>
        @endif
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
        const kelasSelect = document.getElementById('kelas');
        const kategoriKelasSelect = document.getElementById('kategori_kelas');
        const selectedNomorKelas = @json($selectedNomorKelas);

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

        function populateKategoriKelasOptions(selectedValue = null) {
            if (!kelasSelect || !kategoriKelasSelect) {
                return;
            }

            const kelas = kelasSelect.value;
            const prefix = kelas === 'X' ? 'E' : (kelas === 'XI' || kelas === 'XII' ? 'F.P' : null);
            kategoriKelasSelect.innerHTML = '<option value="">-- Pilih Kategori Kelas --</option>';

            if (!prefix) {
                return;
            }

            for (let i = 1; i <= 15; i++) {
                const option = document.createElement('option');
                option.value = String(i);
                option.textContent = `${prefix} - ${i}`;

                if (String(selectedValue) === String(i)) {
                    option.selected = true;
                }

                kategoriKelasSelect.appendChild(option);
            }
        }

        if (kelasSelect && kategoriKelasSelect) {
            kelasSelect.addEventListener('change', function () {
                populateKategoriKelasOptions();
            });

            populateKategoriKelasOptions(selectedNomorKelas);
        }

        syncJenisState();
    })();
</script>
