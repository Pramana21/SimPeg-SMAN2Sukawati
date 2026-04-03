@extends('layouts.app')

@section('content')
<div x-data="{ openModal: @js($errors->any()), activeStatus: @js(old('status', '1') === '1'), showPassword: false }" class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <h1 class="text-4xl font-semibold text-slate-900">Manajemen User</h1>
            <p class="mt-2 text-sm text-slate-500">Kelola akun pengguna, role, dan status akses</p>
        </div>

        <button type="button"
                @click="openModal = true"
                class="inline-flex items-center gap-2 self-start rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
            <i data-feather="plus" class="h-4 w-4"></i>
            Tambah Pengguna
        </button>
    </div>

    @if(session('success'))
        <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="rounded-[28px] border border-slate-200 bg-white/90 p-5 shadow-sm">
        <div class="overflow-hidden rounded-[24px] border border-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-700">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-5 py-4 text-left font-semibold text-slate-800">Username</th>
                            <th class="px-5 py-4 text-left font-semibold text-slate-800">Role</th>
                            <th class="px-5 py-4 text-left font-semibold text-slate-800">Status</th>
                            <th class="px-5 py-4 text-left font-semibold text-slate-800">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($users as $user)
                            <tr class="transition hover:bg-slate-50">
                                <td class="px-5 py-4 font-semibold text-slate-900">{{ $user->username }}</td>
                                <td class="px-5 py-4 text-slate-700">{{ $user->role->role_name ?? '-' }}</td>
                                <td class="px-5 py-4">
                                    @if($user->is_active)
                                        <span class="inline-flex items-center rounded-lg bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-lg bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="{{ route('users.edit', $user->id_user) }}"
                                           class="inline-flex items-center gap-2 rounded-lg bg-blue-500 px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-blue-600">
                                            <i data-feather="edit-2" class="h-4 w-4"></i>
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('users.toggle-status', $user->id_user) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-2 rounded-lg {{ $user->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-emerald-500 hover:bg-emerald-600' }} px-3 py-2 text-xs font-semibold text-white shadow-sm transition">
                                                <i data-feather="{{ $user->is_active ? 'x-circle' : 'check-circle' }}" class="h-4 w-4"></i>
                                                {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-12 text-center text-sm text-slate-500">
                                    Belum ada data pengguna untuk ditampilkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div x-cloak
         x-show="openModal"
         x-transition.opacity
         class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-[2px]">
    </div>

    <div x-cloak
         x-show="openModal"
         x-transition
         @keydown.escape.window="openModal = false"
         class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div @click.away="openModal = false"
             class="w-full max-w-xl rounded-3xl border border-slate-200 bg-white shadow-2xl">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">
                <div>
                    <h2 class="text-2xl font-semibold text-slate-900">Tambah Pengguna</h2>
                    <p class="mt-1 text-sm text-slate-500">Lengkapi data akun pengguna baru.</p>
                </div>

                <button type="button"
                        @click="openModal = false"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 text-slate-500 transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-700">
                    <i data-feather="x" class="h-5 w-5"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('users.store') }}" class="space-y-5 px-6 py-6">
                @csrf
                <div class="space-y-2">
                    <label for="username" class="text-sm font-semibold text-slate-700">Username</label>
                    <input id="username"
                           name="username"
                           type="text"
                           value="{{ old('username') }}"
                           placeholder="Masukkan username"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                </div>

                <div class="space-y-2">
                    <label for="role" class="text-sm font-semibold text-slate-700">Role</label>
                    <div class="relative">
                        <select id="role"
                                name="role_id"
                                class="w-full appearance-none rounded-xl border border-slate-300 bg-white px-4 py-3 pr-11 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                            <option value="" disabled {{ old('role_id') ? '' : 'selected' }}>Pilih role pengguna</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id_role }}" {{ (string) old('role_id') === (string) $role->id_role ? 'selected' : '' }}>
                                    {{ $role->role_name }}
                                </option>
                            @endforeach
                        </select>
                        <i data-feather="chevron-down" class="pointer-events-none absolute right-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                    </div>
                </div>

                <div class="space-y-3">
                    <span class="text-sm font-semibold text-slate-700">Status</span>
                    <input type="hidden" name="status" :value="activeStatus ? '1' : '0'">
                    <div class="flex flex-wrap items-center gap-6">
                        <button type="button"
                                @click="activeStatus = true"
                                :class="activeStatus ? 'text-slate-900' : 'text-slate-400'"
                                class="inline-flex items-center gap-3 text-sm font-medium transition">
                            <span class="relative inline-flex h-6 w-11 items-center rounded-full transition"
                                  :class="activeStatus ? 'bg-blue-500' : 'bg-slate-200'">
                                <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition"
                                      :class="activeStatus ? 'translate-x-5' : 'translate-x-1'"></span>
                            </span>
                            Aktif
                        </button>

                        <button type="button"
                                @click="activeStatus = false"
                                :class="!activeStatus ? 'text-slate-900' : 'text-slate-400'"
                                class="inline-flex items-center gap-3 text-sm font-medium transition">
                            <span class="relative inline-flex h-6 w-11 items-center rounded-full transition"
                                  :class="!activeStatus ? 'bg-blue-500' : 'bg-slate-200'">
                                <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition"
                                      :class="!activeStatus ? 'translate-x-5' : 'translate-x-1'"></span>
                            </span>
                            Nonaktif
                        </button>
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="password" class="text-sm font-semibold text-slate-700">Password</label>
                    <div class="relative">
                        <input id="password"
                               name="password"
                               :type="showPassword ? 'text' : 'password'"
                               placeholder="Masukkan password"
                               class="w-full rounded-xl border border-slate-300 px-4 py-3 pr-11 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                        <button type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 transition hover:text-slate-600">
                            <i x-show="!showPassword" data-feather="eye" class="h-4 w-4"></i>
                            <i x-show="showPassword" data-feather="eye-off" class="h-4 w-4"></i>
                        </button>
                    </div>
                </div>

                <div class="flex justify-end gap-3 border-t border-slate-200 pt-5">
                    <button type="button"
                            @click="openModal = false"
                            class="inline-flex items-center rounded-lg border border-blue-200 px-4 py-2.5 text-sm font-semibold text-blue-600 transition hover:border-blue-300 hover:bg-blue-50">
                        Batal
                    </button>
                    <button type="submit"
                            class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<script>
    document.addEventListener('alpine:init', () => {
        // Alpine handles modal and input states for this page.
    });

    document.addEventListener('DOMContentLoaded', () => {
        feather.replace();
    });
</script>
@endsection
