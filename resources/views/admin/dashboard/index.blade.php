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
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M12 12.25a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M6.75 17.75a5.25 5.25 0 0 1 10.5 0"/>
            </svg>
        </div>
    </div>

    <!-- DOKUMEN -->
    <div class="bg-white rounded-xl shadow p-5 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold">{{ $totalDokumen ?? 0 }}</h2>
            <p class="text-gray-500">Total Dokumen</p>
        </div>
        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M9 5.75h4.75L17.5 9.5v8.75A1.75 1.75 0 0 1 15.75 20H9a1.75 1.75 0 0 1-1.75-1.75V7.5A1.75 1.75 0 0 1 9 5.75Z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M13.75 5.75V9.5h3.75"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M9.75 12.25h5.5m-5.5 2.75h3.5"/>
            </svg>
        </div>
    </div>

    <!-- STAFF -->
    <div class="bg-white rounded-xl shadow p-5 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold">{{ $totalStaff ?? 0 }}</h2>
            <p class="text-gray-500">Total Staff</p>
        </div>
        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M12 12.25a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M7.75 17a4.25 4.25 0 0 1 8.5 0"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M7.5 13.25a2 2 0 1 0-1.99-2m10.99 2a2 2 0 1 0-.01-4"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M4.75 16.5a3.25 3.25 0 0 1 2.5-2.85m9.5 2.85a3.25 3.25 0 0 1 2.5-2.85"/>
            </svg>
        </div>
    </div>

    <!-- SISWA -->
    <div class="bg-white rounded-xl shadow p-5 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold">{{ $totalSiswa ?? 0 }}</h2>
            <p class="text-gray-500">Total Siswa</p>
        </div>
        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M12 11.75a2.75 2.75 0 1 0 0-5.5 2.75 2.75 0 0 0 0 5.5Z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M7.25 17.5a4.75 4.75 0 0 1 9.5 0"/>
            </svg>
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
                <td class="p-3">{{ $log->created_at ? $log->created_at->timezone('Asia/Makassar')->format('d-m-Y H:i') : '-' }}</td>
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
