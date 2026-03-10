@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Data Pegawai</h1>

<a href="{{ route('pegawai.create') }}">
<button class="bg-blue-500 text-white px-4 py-2 rounded mb-4">
Tambah Pegawai
</button>
</a>

<div class="bg-white shadow rounded-lg p-6">

<table class="min-w-full border border-gray-200">

<thead class="bg-gray-100">
<tr>
<th class="px-4 py-2 border">NIP</th>
<th class="px-4 py-2 border">Nama</th>
<th class="px-4 py-2 border">Jabatan</th>
<th class="px-4 py-2 border">Unit Kerja</th>
<th class="px-4 py-2 border">Aksi</th>
</tr>
</thead>

<tbody>

@foreach ($pegawai as $p)

<tr class="hover:bg-gray-50">

<td class="px-4 py-2 border">{{ $p->nip }}</td>
<td class="px-4 py-2 border">{{ $p->nama }}</td>
<td class="px-4 py-2 border">{{ $p->jabatan }}</td>
<td class="px-4 py-2 border">{{ $p->unit_kerja }}</td>

<td class="px-4 py-2 border">

<a href="{{ route('pegawai.edit',$p->id) }}"
class="bg-yellow-500 text-white px-3 py-1 rounded">

Edit

</a>

<form action="{{ route('pegawai.destroy',$p->id) }}"
method="POST"
class="inline">

@csrf
@method('DELETE')

<button class="bg-red-500 text-white px-3 py-1 rounded">

Delete

</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection