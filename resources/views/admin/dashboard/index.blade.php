@extends('layouts.admin')

@section('content')

<h2 class="mb-4">Welcome Back</h2>

<div class="row mb-4">

<div class="col-md-3">
<div class="card shadow-sm">
<div class="card-body">
<h5>Total User</h5>
<h2>{{ $totalUser }}</h2>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card shadow-sm">
<div class="card-body">
<h5>Total Dokumen</h5>
<h2>{{ $totalDokumen }}</h2>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card shadow-sm">
<div class="card-body">
<h5>Total Staff</h5>
<h2>{{ $totalStaff }}</h2>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card shadow-sm">
<div class="card-body">
<h5>Total Siswa</h5>
<h2>{{ $totalSiswa }}</h2>
</div>
</div>
</div>

</div>

<h4>Aktivitas Terakhir (Audit Log)</h4>

<table class="table table-bordered">

<thead>
<tr>
<th>User</th>
<th>Aksi</th>
<th>Modul</th>
<th>Entity/ID</th>
<th>Waktu</th>
</tr>
</thead>

<tbody>

@if(count($auditLogs) > 0)

@foreach($auditLogs as $log)

<tr>
<td>{{ $log->id_user }}</td>
<td>{{ $log->action }}</td>
<td>{{ $log->module }}</td>
<td>{{ $log->entity }}/{{ $log->entity_id }}</td>
<td>{{ $log->created_at }}</td>
</tr>

@endforeach

@else

<tr>
<td colspan="5" class="text-center">
Belum ada aktivitas
</td>
</tr>

@endif

</tbody>

</table>

@endsection