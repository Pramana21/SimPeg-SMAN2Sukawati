@extends('layouts.app')

@section('content')

<div class="space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('murid.index') }}"
           class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-slate-800 text-slate-800 transition hover:bg-slate-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-4xl font-semibold text-slate-900">Mengisi Data Siswa</h1>
            <p class="mt-1 text-sm text-slate-500">Lengkapi data murid lalu unggah foto dengan preview sebelum menyimpan.</p>
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

    <form action="{{ route('murid.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="rounded-[28px] border border-slate-200 bg-white/90 p-6 shadow-sm">
            <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_280px]">
                <div class="space-y-5">
                    <div>
                        <label for="nama_siswa" class="mb-2 block text-sm font-medium text-slate-700">Nama Siswa</label>
                        <input id="nama_siswa" type="text" name="nama_siswa"
                               value="{{ old('nama_siswa') }}"
                               class="w-full rounded-lg border border-slate-200 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                               placeholder="Contoh: I wayan pramana">
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div>
                            <label for="nis" class="mb-2 block text-sm font-medium text-slate-700">NIS</label>
                            <input id="nis" type="text" name="nis"
                                   value="{{ old('nis') }}"
                                   class="w-full rounded-lg border border-slate-200 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                   placeholder="Contoh: 12345">
                        </div>

                        <div>
                            <label for="nik" class="mb-2 block text-sm font-medium text-slate-700">NIK</label>
                            <input id="nik" type="text" name="nik"
                                   value="{{ old('nik') }}"
                                   class="w-full rounded-lg border border-slate-200 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                   placeholder="Contoh: 5104...">
                        </div>

                        <div>
                            <label for="nisn" class="mb-2 block text-sm font-medium text-slate-700">NISN</label>
                            <input id="nisn" type="text" name="nisn"
                                   value="{{ old('nisn') }}"
                                   class="w-full rounded-lg border border-slate-200 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                   placeholder="Contoh: 9988...">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div>
                            <label for="tanggal_lahir" class="mb-2 block text-sm font-medium text-slate-700">Tanggal Lahir</label>
                            <input id="tanggal_lahir" type="date" name="tanggal_lahir"
                                   value="{{ old('tanggal_lahir') }}"
                                   class="w-full rounded-lg border border-slate-200 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                        </div>

                        <div>
                            <label for="jenis_kelamin" class="mb-2 block text-sm font-medium text-slate-700">Gender</label>
                            <select id="jenis_kelamin" name="jenis_kelamin"
                                    class="w-full rounded-lg border border-slate-200 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label for="kelas" class="mb-2 block text-sm font-medium text-slate-700">Kelas</label>
                            <select id="kelas" name="kelas"
                                    class="w-full rounded-lg border border-slate-200 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                <option value="">-- Pilih --</option>
                                <option value="X" {{ old('kelas') === 'X' ? 'selected' : '' }}>X</option>
                                <option value="XI" {{ old('kelas') === 'XI' ? 'selected' : '' }}>XI</option>
                                <option value="XII" {{ old('kelas') === 'XII' ? 'selected' : '' }}>XII</option>
                            </select>
                        </div>
                    </div>

                    <div class="hidden" id="jenisKelasWrapper">
                        <label id="jenisLabel" for="jenisKelas" class="mb-2 block text-sm font-medium text-slate-700"></label>
                        <select name="nomor_kelas" id="jenisKelas"
                                class="w-full rounded-lg border border-slate-200 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                        </select>
                        <p id="kategoriPreview" class="mt-2 text-sm font-medium text-blue-600"></p>
                    </div>

                    <div>
                        <label for="alamat" class="mb-2 block text-sm font-medium text-slate-700">Alamat Siswa</label>
                        <input id="alamat" type="text" name="alamat"
                               value="{{ old('alamat') }}"
                               class="w-full rounded-lg border border-slate-200 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                               placeholder="Contoh: Jalan ...">
                    </div>

                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email Siswa</label>
                        <input id="email" type="email" name="email"
                               value="{{ old('email') }}"
                               class="w-full rounded-lg border border-slate-200 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                               placeholder="Contoh: nama@sma.sch.id">
                    </div>

                    <div>
                        <label for="no_hp" class="mb-2 block text-sm font-medium text-slate-700">No HP Siswa</label>
                        <input id="no_hp" type="text" name="no_hp"
                               value="{{ old('no_hp') }}"
                               class="w-full rounded-lg border border-slate-200 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                               placeholder="Contoh: +628...">
                    </div>

                    <div>
                        <label for="nama_ibu_kandung" class="mb-2 block text-sm font-medium text-slate-700">Nama Ibu Kandung</label>
                        <input id="nama_ibu_kandung" type="text" name="nama_ibu_kandung"
                               value="{{ old('nama_ibu_kandung') }}"
                               class="w-full rounded-lg border border-slate-200 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                               placeholder="Contoh: Ni Luh...">
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <label for="fotoInput" class="mb-3 block text-sm font-medium text-slate-700">Upload Foto Siswa</label>
                        <input type="file" name="foto" id="fotoInput" accept="image/*" class="hidden">

                        <label for="fotoInput"
                               class="flex min-h-[220px] cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-300 bg-white px-6 py-8 text-center transition hover:border-blue-400 hover:bg-blue-50/40">
                            <div id="previewFotoWrapper"
                                 class="mb-4 hidden h-[250px] w-[250px] max-w-full overflow-hidden rounded-xl shadow-sm">
                                <img id="previewFoto"
                                     src=""
                                     class="h-full w-full object-cover object-center">
                            </div>
                            <div id="uploadText" class="flex flex-col items-center">
                                <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-blue-600 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </span>
                                <p class="mt-3 text-sm font-medium text-slate-700">Klik untuk memilih foto</p>
                                <p class="mt-1 text-xs text-slate-500">JPG, JPEG, PNG. Maksimal 2 MB.</p>
                            </div>
                            <p id="fotoStatus" class="mt-3 text-sm font-semibold text-blue-600">Belum ada file dipilih</p>
                        </label>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                        <p class="font-medium text-slate-800">Status Upload</p>
                        <p class="mt-2">Preview akan tampil otomatis setelah file dipilih.</p>
                        <p class="mt-1">Jika file tidak valid, form akan menampilkan pesan error setelah submit.</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-center">
                <button class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                    Simpan Data
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    (function () {
        const kelasSelect = document.getElementById('kelas');
        const jenisKelasWrapper = document.getElementById('jenisKelasWrapper');
        const jenisKelasSelect = document.getElementById('jenisKelas');
        const jenisLabel = document.getElementById('jenisLabel');
        const kategoriPreview = document.getElementById('kategoriPreview');
        const selectedNomorKelas = @json(old('nomor_kelas'));
        const fotoInput = document.getElementById('fotoInput');
        const previewFotoWrapper = document.getElementById('previewFotoWrapper');
        const previewFoto = document.getElementById('previewFoto');
        const uploadText = document.getElementById('uploadText');
        const fotoStatus = document.getElementById('fotoStatus');

        function updateKategoriPreview() {
            const kelas = kelasSelect.value;
            const nomor = jenisKelasSelect.value;

            if (!kelas || !nomor) {
                kategoriPreview.innerText = '';
                return;
            }

            const prefix = kelas === 'X' ? 'E' : 'F';
            kategoriPreview.innerText = `Kategori otomatis: ${prefix} - ${nomor}`;
        }

        function populateKategoriOptions() {
            const value = kelasSelect.value;
            jenisKelasSelect.innerHTML = '';

            if (value === 'X') {
                jenisLabel.innerText = 'Kelas E';
                jenisKelasWrapper.classList.remove('hidden');
            } else if (value === 'XI' || value === 'XII') {
                jenisLabel.innerText = 'Kelas F';
                jenisKelasWrapper.classList.remove('hidden');
            } else {
                jenisKelasWrapper.classList.add('hidden');
                kategoriPreview.innerText = '';
                return;
            }

            for (let i = 1; i <= 10; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = `Nomor ${i}`;

                if (String(selectedNomorKelas) === String(i)) {
                    option.selected = true;
                }

                jenisKelasSelect.appendChild(option);
            }

            updateKategoriPreview();
        }

        function resetPreview() {
            previewFotoWrapper.classList.add('hidden');
            previewFoto.removeAttribute('src');
            uploadText.classList.remove('hidden');
            fotoStatus.textContent = 'Belum ada file dipilih';
        }

        kelasSelect.addEventListener('change', populateKategoriOptions);
        jenisKelasSelect.addEventListener('change', updateKategoriPreview);

        fotoInput.addEventListener('change', function (e) {
            const file = e.target.files[0];

            if (!file) {
                resetPreview();
                return;
            }

            if (!file.type.startsWith('image/')) {
                fotoStatus.textContent = 'File harus berupa gambar yang valid.';
                previewFotoWrapper.classList.add('hidden');
                previewFoto.removeAttribute('src');
                uploadText.classList.remove('hidden');
                return;
            }

            previewFoto.src = URL.createObjectURL(file);
            previewFotoWrapper.classList.remove('hidden');
            uploadText.classList.add('hidden');
            fotoStatus.textContent = `File dipilih: ${file.name}`;
        });

        populateKategoriOptions();
    })();
</script>

@endsection
