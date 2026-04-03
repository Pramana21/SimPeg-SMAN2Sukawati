@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('keuangan.kategori', $slug) }}"
           class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-slate-800 text-slate-800 transition hover:bg-slate-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-4xl font-semibold text-slate-900">Edit Dokumen</h1>
            <p class="mt-1 text-sm text-slate-500">Form edit menggunakan struktur yang sama dengan form tambah dan data sudah terisi otomatis.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm">
        <form action="{{ route('keuangan.update', [$slug, $data->id_dokumen_keuangan]) }}"
              method="POST"
              enctype="multipart/form-data"
              class="max-w-3xl">
            @csrf
            @method('PUT')

            @include('admin.keuangan.partials.form', [
                'kategori' => $kategori,
                'submitLabel' => 'Update',
                'data' => $data,
            ])
        </form>
    </div>
</div>
@endsection
