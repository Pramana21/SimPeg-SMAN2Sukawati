@extends('layouts.app')

@section('content')

<!-- TITLE -->
<!-- <h1 class="text-2xl font-semibold mb-6">Welcome Back</h1> -->

<!-- CARD -->
<div class="grid grid-cols-4 gap-6 mb-6">

    <!-- USER -->
    <div class="bg-white rounded-xl shadow p-5 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold">{{ $totalUser ?? 0 }}</h2>
            <p class="text-gray-500">Total User</p>
        </div>
        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
            <i data-feather="user" class="text-white"></i>
        </div>
    </div>

    <!-- DOKUMEN -->
    <div class="bg-white rounded-xl shadow p-5 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold">{{ $totalDokumen ?? 0 }}</h2>
            <p class="text-gray-500">Total Dokumen</p>
        </div>
        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
            <i data-feather="file" class="text-white"></i>
        </div>
    </div>

    <!-- STAFF -->
    <div class="bg-white rounded-xl shadow p-5 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold">{{ $totalStaff ?? 0 }}</h2>
            <p class="text-gray-500">Total Staff</p>
        </div>
        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
            <i data-feather="users" class="text-white"></i>
        </div>
    </div>

    <!-- SISWA -->
    <div class="bg-white rounded-xl shadow p-5 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold">{{ $totalSiswa ?? 0 }}</h2>
            <p class="text-gray-500">Total Siswa</p>
        </div>
        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
            <i data-feather="user" class="text-white"></i>
        </div>
    </div>

</div>

<!-- AUDIT LOG -->
<div class="bg-white rounded-xl shadow p-6">

    <h2 class="text-lg font-semibold mb-4">
        Aktivitas Terakhir (Audit Log)
    </h2>

    <table class="w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-left">User</th>
                <th class="p-3 text-left">Aksi</th>
                <th class="p-3 text-left">Modul</th>
                <th class="p-3 text-left">Keterangan</th>
                <th class="p-3 text-left">Waktu</th>
            </tr>
        </thead>

        <tbody>

        @forelse($logs as $log)
            <tr class="border-b">
                <td class="p-3">{{ $log->user?->username ?? $log->nama_pengguna ?? '-' }}</td>
                <td class="p-3">{{ $log->aktivitas ?? '-' }}</td>
                <td class="p-3">{{ $log->modul ?? '-' }}</td>
                <td class="p-3">{{ $log->keterangan ?? '-' }}</td>
                <td class="p-3">{{ $log->created_at ? $log->created_at->format('d-m-Y H:i') : '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center p-6 text-gray-400">
                    Belum ada aktivitas
                </td>
            </tr>
        @endforelse

        </tbody>

    </table>

</div>

@endsection
