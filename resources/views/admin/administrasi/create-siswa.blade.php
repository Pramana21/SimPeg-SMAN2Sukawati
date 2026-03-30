@extends('layouts.app')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route($backRoute) }}"
           class="inline-flex h-14 w-14 items-center justify-center rounded-full border-2 border-slate-900 text-slate-900 transition hover:bg-slate-900 hover:text-white">
            <i data-feather="arrow-left" class="h-7 w-7"></i>
        </a>
        <div>
            <h1 class="text-4xl font-semibold text-slate-900">Tambah Dokumen</h1>
            <p class="mt-1 text-sm text-slate-500">Tambahkan dokumen siswa dengan jenis dokumen yang sesuai.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('administrasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <input type="hidden" name="selected_kategori" value="Siswa">

        @include('admin.administrasi.partials.form', [
            'submitLabel' => 'Upload',
            'data' => null,
            'jenisDokumenOptions' => $jenisDokumenOptions,
        ])
    </form>
</div>
@endsection
