@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route($backRoute) }}"
               class="inline-flex h-14 w-14 items-center justify-center rounded-full border-2 border-slate-900 text-slate-900 transition hover:bg-slate-900 hover:text-white">
                <i data-feather="arrow-left" class="h-7 w-7"></i>
            </a>
            <div>
                <h1 class="text-4xl font-semibold text-slate-900">Preview Administrasi</h1>
                <p class="mt-1 text-sm text-slate-500">Halaman ini read-only untuk melihat detail dokumen administrasi umum.</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('administrasi.edit', $data->id_dokumen_administrasi) }}"
               class="inline-flex items-center gap-2 rounded-lg bg-green-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M17.414 2.586a2 2 0 010 2.828l-8.5 8.5a2 2 0 01-.878.497l-3 1a1 1 0 01-1.265-1.265l1-3a2 2 0 01.497-.878l8.5-8.5a2 2 0 012.828 0zm-9.62 8.206L5.91 12.676l-.38 1.14 1.14-.38 1.884-1.883-1.06-1.061z"/>
                </svg>
                Edit
            </a>

            @if($fileUrl)
                <a href="{{ $fileUrl }}" target="_blank"
                   class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M12.293 2.293a1 1 0 011.414 0l4 4A1 1 0 0117 8h-1v7a2 2 0 01-2 2H6a2 2 0 01-2-2V8H3a1 1 0 01-.707-1.707l4-4a1 1 0 011.414 1.414L5.414 6H7a1 1 0 011 1v8h4V7a1 1 0 011-1h1.586l-2.293-2.293a1 1 0 010-1.414z"/>
                    </svg>
                    Buka File
                </a>
            @endif
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.05fr_1.4fr]">
        <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Informasi Dokumen</h2>

            <div class="mt-6 space-y-5">
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-500">Nama Dokumen</label>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-800">{{ $data->nama_dokumen }}</div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-500">Kategori</label>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-800">{{ $data->jenis->kategori->nama_kategori ?? '-' }}</div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-500">Jenis Dokumen</label>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-800">{{ $data->jenis->nama_jenis ?? '-' }}</div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-500">Tanggal</label>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-800">{{ \Illuminate\Support\Carbon::parse($data->tanggal_dokumen)->format('d F Y') }}</div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-500">Di-upload oleh</label>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-800">{{ $data->created_by }}</div>
                </div>
            </div>
        </div>

        <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Preview File</h2>

            <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
                @if($fileUrl && $isPreviewable)
                    @if(\Illuminate\Support\Str::endsWith(strtolower($data->file_path), ['.jpg', '.jpeg', '.png']))
                        <img src="{{ $fileUrl }}" alt="{{ $data->nama_dokumen }}" class="h-[620px] w-full object-contain bg-white">
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
