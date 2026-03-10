@extends('layouts.app')

@section('content')
<h1>Data Pegawai</h1>

<a href="{{ route('pegawai.create') }}">
    <button>Tambah Pegawai</button>
</a>

<table border="1">
<tr>
<th>NIP</th>
<th>Nama</th>
<th>Jabatan</th>
<th>Unit Kerja</th>
<th>Aksi</th>
</tr>

@foreach ($pegawai as $p)
<tr>

<td>{{ $p->nip }}</td>
<td>{{ $p->nama }}</td>
<td>{{ $p->jabatan }}</td>
<td>{{ $p->unit_kerja }}</td>

<td>

<a href="{{ route('pegawai.edit', $p->id) }}">
<button>Edit</button>
</a>

<form action="{{ route('pegawai.destroy', $p->id) }}" method="POST" style="display:inline">

@csrf
@method('DELETE')

<button type="submit">Delete</button>

</form>

</td>

</tr>
@endforeach

</table>
@endsection