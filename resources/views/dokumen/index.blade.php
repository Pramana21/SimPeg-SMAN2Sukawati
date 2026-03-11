@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">
Data Dokumen Pegawai
</h1>

<table class="w-full border">

<thead class="bg-gray-200">

<tr>

<th class="p-2">Pegawai</th>
<th class="p-2">Nama Dokumen</th>
<th class="p-2">File</th>
<th class="p-2">Aksi</th>

</tr>

</thead>

<tbody>

@foreach($dokumen as $d)

<tr class="border">

<td class="p-2">
{{ $d->pegawai->nama }}
</td>

<td class="p-2">
{{ $d->nama_dokumen }}
</td>

<td class="p-2">

<a href="/dokumen/{{ $d->file_dokumen }}" target="_blank"
class="text-blue-500">

Lihat File

</a>

</td>

<td class="p-2">

<form action="{{ route('dokumen.destroy',$d->id) }}" method="POST">

@csrf
@method('DELETE')

<button class="bg-red-500 text-white px-2 py-1 rounded">

Hapus

</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

@endsection