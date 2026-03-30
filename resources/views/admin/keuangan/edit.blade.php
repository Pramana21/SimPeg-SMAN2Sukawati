@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('keuangan.kategori', $slug) }}"
           class="inline-flex h-14 w-14 items-center justify-center rounded-full border-2 border-slate-900 text-slate-900 transition hover:bg-slate-900 hover:text-white">
            <i data-feather="arrow-left" class="h-7 w-7"></i>
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
