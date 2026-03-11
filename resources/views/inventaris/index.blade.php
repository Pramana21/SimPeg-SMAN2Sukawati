@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">
Data Inventaris
</h1>

<a href="/inventaris/create"
class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">

Tambah Inventaris

</a>

<table class="w-full border">

<thead class="bg-gray-200">

<tr>

<th class="p-2">Nama Barang</th>
<th class="p-2">Jumlah</th>
<th class="p-2">Kondisi</th>

</tr>

</thead>

<tbody>

@foreach($inventaris as $i)

<tr class="border">

<td class="p-2">
{{ $i->nama_barang }}
</td>

<td class="p-2">
{{ $i->jumlah }}
</td>

<td class="p-2">
{{ $i->kondisi }}
</td>

</tr>

@endforeach

</tbody>

</table>

@endsection