@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('penyuratan.index') }}"
               class="inline-flex h-14 w-14 items-center justify-center rounded-full border-2 border-slate-900 text-slate-900 transition hover:bg-slate-900 hover:text-white">
                <i data-feather="arrow-left" class="h-7 w-7"></i>
            </a>
            <div>
                <h1 class="text-4xl font-semibold text-slate-900">Preview Surat</h1>
                <p class="mt-1 text-sm text-slate-500">Halaman ini read-only untuk melihat detail surat yang tersimpan.</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('penyuratan.edit', $surat->id_dokumen_penyuratan) }}"
               class="inline-flex items-center gap-2 rounded-lg bg-emerald-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-600">
                <i data-feather="edit-2" class="h-4 w-4"></i>
                Edit
            </a>
            @if($fileUrl)
                <a href="{{ $fileUrl }}" target="_blank"
                   class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                    <i data-feather="external-link" class="h-4 w-4"></i>
                    Buka File
                </a>
            @endif
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.1fr_1.4fr]">
        <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Informasi Surat</h2>

            <div class="mt-6 space-y-5">
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-500">No Surat</label>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-800">{{ $surat->no_surat }}</div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-500">Perihal</label>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-800">{{ $surat->nama_dokumen }}</div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-500">Jenis Surat</label>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-800">{{ $surat->jenis->nama_jenis_surat ?? '-' }}</div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-500">Tanggal</label>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-800">{{ \Illuminate\Support\Carbon::parse($surat->tanggal_dokumen)->format('d F Y') }}</div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-500">Nama Pengirim/Penerima</label>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-800">{{ $surat->nama_pengirim_penerima }}</div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-500">Dibuat Oleh</label>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-800">{{ $surat->created_by }}</div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-500">Nama File</label>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-800">{{ basename($surat->file_path) }}</div>
                </div>
            </div>
        </div>

        <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Preview File</h2>

            <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
                @if($fileUrl && $isPreviewable)
                    @if(\Illuminate\Support\Str::endsWith(strtolower($surat->file_path), ['.jpg', '.jpeg', '.png']))
                        <img src="{{ $fileUrl }}" alt="{{ $surat->nama_dokumen }}" class="h-[620px] w-full object-contain bg-white">
                    @else
                        <iframe src="{{ $fileUrl }}" class="h-[620px] w-full bg-white"></iframe>
                    @endif
                @else
                    <div class="flex h-[620px] flex-col items-center justify-center px-8 text-center">
                        <i data-feather="file-text" class="h-12 w-12 text-slate-300"></i>
                        <p class="mt-4 text-base font-medium text-slate-700">File tidak mendukung preview langsung di halaman ini.</p>
                        <p class="mt-2 text-sm text-slate-500">Gunakan tombol "Buka File" untuk melihat dokumen secara read-only di tab baru.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
