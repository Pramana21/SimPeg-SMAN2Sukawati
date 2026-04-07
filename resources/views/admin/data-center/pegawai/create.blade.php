@extends('layouts.app')

@section('content')
@php
    $isEdit = isset($data) && $data;
@endphp

<div class="space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('pegawai.index') }}"
           class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-slate-800 text-slate-800 transition hover:bg-slate-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-4xl font-semibold text-slate-900">{{ $isEdit ? 'Edit Data Pegawai' : 'Mengisi Data Pegawai' }}</h1>
            <p class="mt-1 text-sm text-slate-500">Lengkapi data staff atau guru, lalu unggah foto dengan preview sebelum menyimpan.</p>
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

    <form action="{{ $isEdit ? route('pegawai.update', $data->id_pegawai) : route('pegawai.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="rounded-[28px] border border-slate-200 bg-white/90 p-6 shadow-sm">
            <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_280px]">
                <div class="space-y-5">
                    <div>
                        <label for="nama_pegawai" class="mb-2 block text-sm font-medium text-slate-700">Nama Pegawai</label>
                        <input id="nama_pegawai" type="text" name="nama_pegawai"
                               value="{{ old('nama_pegawai', $data->nama_pegawai ?? '') }}"
                               class="w-full rounded-lg border border-slate-200 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                               placeholder="Contoh: i wayan pramana"
                               required>
                    </div>

                    <div class="grid gap-4 md:grid-cols-3">
                        <div>
                            <label for="nip" class="mb-2 block text-sm font-medium text-slate-700">NIP/NIPPK</label>
                            <input id="nip" type="text" name="nip"
                                   value="{{ old('nip', $data->nip_nippk ?? '') }}"
                                   class="w-full rounded-lg border border-slate-200 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                   placeholder="Contoh: 12345">
                        </div>

                        <div>
                            <label for="nik" class="mb-2 block text-sm font-medium text-slate-700">NIK</label>
                            <input id="nik" type="text" name="nik"
                                   value="{{ old('nik', $data->nik ?? '') }}"
                                   class="w-full rounded-lg border border-slate-200 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                   placeholder="Contoh: 5104...">
                        </div>

                        <div>
                            <label for="nuptk" class="mb-2 block text-sm font-medium text-slate-700">NUPTK</label>
                            <input id="nuptk" type="text" name="nuptk"
                                   value="{{ old('nuptk', $data->nuptk ?? '') }}"
                                   class="w-full rounded-lg border border-slate-200 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                   placeholder="Contoh: 12345">
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-3">
                        <div>
                            <label for="tanggal_lahir" class="mb-2 block text-sm font-medium text-slate-700">Tanggal Lahir</label>
                            <input id="tanggal_lahir" type="date" name="tanggal_lahir"
                                   value="{{ old('tanggal_lahir', $data->tanggal_lahir ?? '') }}"
                                   class="w-full rounded-lg border border-slate-200 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                        </div>

                        <div>
                            <label for="jenis_kelamin" class="mb-2 block text-sm font-medium text-slate-700">Gender</label>
                            <select id="jenis_kelamin" name="jenis_kelamin"
                                    class="w-full rounded-lg border border-slate-200 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin', $data->jenis_kelamin ?? '') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $data->jenis_kelamin ?? '') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label for="status_pegawai" class="mb-2 block text-sm font-medium text-slate-700">Status Pegawai</label>
                            <select id="status_pegawai" name="status_pegawai"
                                    class="w-full rounded-lg border border-slate-200 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                <option value="">-- Pilih --</option>
                                @foreach(['Honor','PNS','PKKK','Kontrak Provinsi','OJTM'] as $status)
                                    <option value="{{ $status }}" {{ old('status_pegawai', $data->status_pegawai ?? '') === $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="pendidikan_terakhir" class="mb-2 block text-sm font-medium text-slate-700">Pendidikan Terakhir</label>
                        <input id="pendidikan_terakhir" type="text" name="pendidikan_terakhir"
                               value="{{ old('pendidikan_terakhir', $data->pendidikan_terakhir ?? '') }}"
                               class="w-full rounded-lg border border-slate-200 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                               placeholder="Contoh: Sarjana">
                    </div>

                    <div>
                        <label for="alamat" class="mb-2 block text-sm font-medium text-slate-700">Alamat Pegawai</label>
                        <input id="alamat" type="text" name="alamat"
                               value="{{ old('alamat', $data->alamat ?? '') }}"
                               class="w-full rounded-lg border border-slate-200 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                               placeholder="Contoh: Jl. Raya Sukawati">
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email Pegawai</label>
                            <input id="email" type="email" name="email"
                                   value="{{ old('email', $data->email ?? '') }}"
                                   class="w-full rounded-lg border border-slate-200 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                   placeholder="Contoh: nama@sma.sch.id">
                        </div>

                        <div>
                            <label for="no_hp" class="mb-2 block text-sm font-medium text-slate-700">No HP Pegawai</label>
                            <input id="no_hp" type="text" name="no_hp"
                                   value="{{ old('no_hp', $data->no_hp ?? '') }}"
                                   class="w-full rounded-lg border border-slate-200 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                   placeholder="Contoh: +628...">
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <label for="fotoInput" class="mb-3 block text-sm font-medium text-slate-700">Upload Foto Pegawai</label>
                        <input type="file" name="foto" id="fotoInput" accept="image/*" class="hidden">

                        <label for="fotoInput"
                               class="flex min-h-[220px] cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-300 bg-white px-6 py-8 text-center transition hover:border-blue-400 hover:bg-blue-50/40">
                            <div id="previewFotoWrapper"
                                 class="mb-4 {{ isset($data) && $data?->foto_path ? '' : 'hidden' }} h-[250px] w-[250px] max-w-full overflow-hidden rounded-xl shadow-sm">
                                <img id="previewFoto"
                                     src="{{ old('foto') ? '' : (isset($data) && $data?->foto_path ? asset('storage/' . $data->foto_path) : '') }}"
                                     class="h-full w-full object-cover object-center">
                            </div>
                            <div id="uploadText" class="{{ isset($data) && $data?->foto_path ? 'hidden' : 'flex' }} flex-col items-center">
                                <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-blue-600 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </span>
                                <p class="mt-3 text-sm font-medium text-slate-700">Klik untuk memilih foto</p>
                                <p class="mt-1 text-xs text-slate-500">JPG, JPEG, PNG. Maksimal 2 MB.</p>
                            </div>
                            <p id="fotoStatus" class="mt-3 text-sm font-semibold text-blue-600">
                                {{ isset($data) && $data?->foto_path ? basename($data->foto_path) : 'Belum ada file dipilih' }}
                            </p>
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
                    {{ $isEdit ? 'Update Data' : 'Simpan Data' }}
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    (function () {
        const fotoInput = document.getElementById('fotoInput');
        const previewFotoWrapper = document.getElementById('previewFotoWrapper');
        const previewFoto = document.getElementById('previewFoto');
        const uploadText = document.getElementById('uploadText');
        const fotoStatus = document.getElementById('fotoStatus');
        const existingPhotoSrc = previewFoto.getAttribute('src');

        if (!fotoInput || !previewFoto || !previewFotoWrapper || !uploadText || !fotoStatus) {
            return;
        }

        function showExistingPreview() {
            if (existingPhotoSrc) {
                previewFotoWrapper.classList.remove('hidden');
                uploadText.classList.add('hidden');
                return;
            }

            previewFotoWrapper.classList.add('hidden');
            uploadText.classList.remove('hidden');
        }

        fotoInput.addEventListener('change', function (e) {
            const file = e.target.files[0];

            if (!file) {
                fotoStatus.textContent = existingPhotoSrc ? '{{ isset($data) && $data?->foto_path ? basename($data->foto_path) : 'Belum ada file dipilih' }}' : 'Belum ada file dipilih';
                previewFoto.src = existingPhotoSrc || '';
                showExistingPreview();
                return;
            }

            if (!file.type.startsWith('image/')) {
                fotoStatus.textContent = 'File harus berupa gambar yang valid.';
                showExistingPreview();
                return;
            }

            fotoStatus.textContent = `File dipilih: ${file.name}`;
            previewFoto.src = URL.createObjectURL(file);
            previewFotoWrapper.classList.remove('hidden');
            uploadText.classList.add('hidden');
        });

        showExistingPreview();
    })();
</script>
@endsection
