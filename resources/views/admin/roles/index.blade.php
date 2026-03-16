@extends('layouts.app')

@section('content')

<div class="p-6">

    <!-- Title -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Role & Hak Akses</h1>
        <p class="text-gray-500">Kelola peran dan hak akses pengguna</p>
    </div>

    <div class="grid grid-cols-3 gap-6">

        <!-- List Role -->
        <div class="bg-white rounded-lg shadow">

            <div class="p-4 border-b font-semibold">
                List Role
            </div>

            <ul>

                @foreach($roles as $role)

                <li class="px-4 py-3 hover:bg-blue-50 cursor-pointer border-b">

                    {{ $role->role_name }}

                </li>

                @endforeach

            </ul>

        </div>


        <!-- Hak Akses -->
        <div class="col-span-2 bg-white rounded-lg shadow">

            <div class="p-4 border-b flex justify-between items-center">

                <div>
                    <h2 class="text-xl font-semibold">
                        Hak Akses
                    </h2>
                    <p class="text-gray-500 text-sm">
                        Mengelola akses modul
                    </p>
                </div>

                <button class="bg-blue-500 text-white px-4 py-2 rounded">
                    Edit Informasi Role
                </button>

            </div>

            <div class="p-6">

                <!-- Modul -->
                <h3 class="font-semibold mb-3">
                    Modul yang dapat diakses
                </h3>

                <div class="grid grid-cols-2 gap-3">

                    <label class="flex items-center gap-2">
                        <input type="checkbox" checked>
                        Dashboard
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" checked>
                        Penyuratan
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" checked>
                        Keuangan
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" checked>
                        Inventaris
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" checked>
                        Data Center
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" checked>
                        Administrasi Umum
                    </label>

                </div>

                <!-- Akses -->
                <div class="mt-6">

                    <h3 class="font-semibold mb-3">
                        Akses yang diizinkan
                    </h3>

                    <div class="space-y-2">

                        <label class="flex items-center gap-2">
                            <input type="checkbox" checked>
                            Kelola data (Tambah/Ubah/Hapus)
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" checked>
                            Lihat detail
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" checked>
                            Unduh dokumen
                        </label>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection