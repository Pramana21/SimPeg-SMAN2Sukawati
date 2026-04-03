@extends('layouts.app')

@section('content')

<div class="p-6">

    <!-- TITLE -->
    <h1 class="text-2xl font-semibold text-gray-800 mb-1">
        Role & Hak Akses
    </h1>
    <p class="text-gray-500 mb-6">
        Kelola peran dan hak akses pengguna
    </p>

    <div class="grid grid-cols-3 gap-6">

        <!-- LEFT: LIST ROLE -->
        <div class="bg-white rounded-xl shadow p-4">

            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold">List Role</h2>
                <i data-feather="chevron-down"></i>
            </div>

            <div class="space-y-2">

                @foreach($roles as $role)

                    <a href="{{ url('/roles/'.$role->id_role) }}">

                        <div class="p-2 rounded cursor-pointer
                            {{ $selectedRole && $selectedRole->id_role == $role->id_role 
                                ? 'bg-blue-100 border-l-4 border-blue-500 text-blue-600' 
                                : 'hover:bg-gray-100' }}">

                            {{ $role->role_name }}

                        </div>

                    </a>

                @endforeach

            </div>

        </div>

        <!-- RIGHT: DETAIL -->
        <div class="col-span-2 bg-white rounded-xl shadow p-6">

            <div class="mb-4">

                <div>
                    <h2 class="text-xl font-semibold">
                        Hak Akses: {{ $selectedRole->role_name }}
                    </h2>

                    <p class="text-gray-500 text-sm">
                        {{ $selectedRole->description }}
                    </p>
                </div>

            </div>

            <!-- MODUL -->
            <div class="mb-6">

                <h3 class="font-semibold mb-3">Modul yang dapat diakses</h3>

                <div class="grid grid-cols-2 gap-3">

                    @foreach($rolePermissions['modules'] as $module)
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-500">
                                ✔
                            </div>
                            {{ $module }}
                        </div>
                    @endforeach

                </div>

            </div>

            <!-- AKSES -->
            <div>

                <h3 class="font-semibold mb-3">Akses yang diizinkan</h3>

                <div class="space-y-2">

                    @foreach($rolePermissions['actions'] as $action)
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-500">
                                ✔
                            </div>
                            {{ $action }}
                        </div>
                    @endforeach

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
