@extends('layouts.app')

@section('content')

<div class="p-6">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('pegawai.index') }}"
           class="w-10 h-10 flex items-center justify-center border rounded-full">
            ←
        </a>

        <h1 class="text-xl font-semibold">Edit Data Pegawai</h1>
    </div>

    <form action="{{ route('pegawai.update', $pegawai->id_pegawai) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 rounded-xl shadow space-y-4 max-w-3xl">

            <input type="text" name="nama_pegawai" value="{{ $pegawai->nama_pegawai }}" placeholder="Nama">

            <input type="text" name="nip" value="{{ $pegawai->nip }}" placeholder="NIP">
            <input type="text" name="nik" value="{{ $pegawai->nik }}" placeholder="NIK">
            <input type="text" name="nuptk" value="{{ $pegawai->nuptk }}" placeholder="NUPTK">

            <input type="date" name="tanggal_lahir" value="{{ $pegawai->tanggal_lahir }}">

            <select name="jenis_kelamin">
                <option {{ $pegawai->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option {{ $pegawai->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>

            <select name="status_pegawai">
                @foreach(['Honor','PNS','PKKK','Kontrak','Kontrak Provinsi','OJTM'] as $status)
                    <option value="{{ $status }}" {{ $pegawai->status_pegawai == $status ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                @endforeach
            </select>

            <input type="text" name="pendidikan" value="{{ $pegawai->pendidikan_terakhir }}">
            <input type="text" name="alamat" value="{{ $pegawai->alamat }}">
            <input type="email" name="email" value="{{ $pegawai->email }}">
            <input type="text" name="no_hp" value="{{ $pegawai->no_hp }}">

            {{-- FOTO --}}
            @if($pegawai->foto_path)
                <img src="{{ asset('storage/' . $pegawai->foto_path) }}" class="w-32">
            @endif

            <input type="file" name="foto">

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Update Data
            </button>

        </div>

    </form>

</div>

@endsection