@extends('layouts.app')

@section('content')
<div x-data="{ openModal: @js($errors->any()), activeStatus: @js(old('status', '1') === '1'), showPassword: false }" class="space-y-6">
    <div>
        <div>
            <h1 class="text-4xl font-semibold text-slate-900">Manajemen User</h1>
            <p class="mt-2 text-sm text-slate-500">Kelola akun pengguna, role, dan status akses</p>
        </div>
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
        @can('manajemen_user.create')
        <div class="mb-5">
            <button type="button"
                    @click="openModal = true"
                    class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold leading-none text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 4a.75.75 0 01.75.75v4.5h4.5a.75.75 0 010 1.5h-4.5v4.5a.75.75 0 01-1.5 0v-4.5h-4.5a.75.75 0 010-1.5h4.5v-4.5A.75.75 0 0110 4z" clip-rule="evenodd" />
                </svg>
                Tambah Pengguna
            </button>
        </div>
        @endcan

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
                                        <span class="inline-flex items-center rounded-lg bg-green-500 px-3 py-1 text-xs font-semibold text-white shadow-sm">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-lg bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2 flex-nowrap">
                                        @can('manajemen_user.edit')
                                        <a href="{{ route('users.edit', $user->id_user) }}"
                                           class="inline-flex shrink-0 items-center gap-1.5 rounded-lg bg-blue-500 px-3 py-1.5 text-xs font-semibold leading-none text-white shadow-sm transition hover:bg-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M5 13.75V16h2.25l6.28-6.28-2.25-2.25L5 13.75z" />
                                                <path d="M14.71 6.04a1 1 0 000-1.41L13.37 3.3a1 1 0 00-1.41 0l-.88.88 2.25 2.25.88-.39z" />
                                            </svg>
                                            Edit
                                        </a>
                                        @endcan

                                        @can('manajemen_user.edit')
                                        <form method="POST"
                                              action="{{ route('users.toggle-status', $user->id_user) }}"
                                              class="inline-flex shrink-0 m-0">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="inline-flex shrink-0 items-center gap-1.5 rounded-lg {{ $user->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-emerald-500 hover:bg-emerald-600' }} px-3 py-1.5 text-xs font-semibold leading-none text-white shadow-sm transition">
                                                @if($user->is_active)
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.03-10.97a.75.75 0 10-1.06-1.06L10 7.94 8.03 5.97a.75.75 0 10-1.06 1.06L8.94 9l-1.97 1.97a.75.75 0 101.06 1.06L10 10.06l1.97 1.97a.75.75 0 001.06-1.06L11.06 9l1.97-1.97z" clip-rule="evenodd" />
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.36-9.97a.75.75 0 10-1.22-.86l-2.8 3.96-1.48-1.48a.75.75 0 10-1.06 1.06l2.1 2.1a.75.75 0 001.14-.09l3.32-4.7z" clip-rule="evenodd" />
                                                    </svg>
                                                @endif
                                                {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                        @endcan

                                        @if(!$user->is_active)
                                            @can('manajemen_user.delete')
                                            <form method="POST"
                                                  action="{{ route('users.destroy', $user->id_user) }}"
                                                  class="inline-flex shrink-0 m-0"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini secara permanen?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex shrink-0 items-center gap-1.5 rounded-lg bg-red-500 px-3 py-1.5 text-xs font-semibold leading-none text-white shadow-sm transition hover:bg-red-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M6 7a1 1 0 011-1h6a1 1 0 011 1v7a2 2 0 01-2 2H8a2 2 0 01-2-2V7zm3-3a1 1 0 00-1 1v1h4V5a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                                        <path d="M4 7.75A.75.75 0 014.75 7h10.5a.75.75 0 010 1.5H14v5.25A3.25 3.25 0 0110.75 17h-1.5A3.25 3.25 0 016 13.75V8.5H4.75A.75.75 0 014 7.75z" />
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                            @endcan
                                        @endif
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

    @can('manajemen_user.create')
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
             class="relative w-full max-w-xl rounded-3xl border border-slate-200 bg-white shadow-2xl">
            <button type="button"
                    @click="openModal = false"
                    class="absolute right-4 top-4 inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-300 text-slate-500 transition hover:border-slate-400 hover:bg-slate-50 hover:text-slate-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="border-b border-slate-200 px-6 py-5 pr-20">
                <div>
                    <h2 class="text-2xl font-semibold text-slate-900">Tambah Pengguna</h2>
                    <p class="mt-1 text-sm text-slate-500">Lengkapi data akun pengguna baru.</p>
                </div>
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
                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button"
                                @click="activeStatus = true"
                                :class="activeStatus ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-slate-300 bg-white text-slate-500 hover:border-slate-400 hover:text-slate-700'"
                                class="inline-flex items-center gap-3 rounded-xl border px-4 py-2 text-sm font-medium transition">
                            <span class="relative inline-flex h-6 w-11 items-center rounded-full transition"
                                  :class="activeStatus ? 'bg-blue-500' : 'bg-slate-200'">
                                <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition"
                                      :class="activeStatus ? 'translate-x-5' : 'translate-x-1'"></span>
                            </span>
                            Aktif
                        </button>

                        <button type="button"
                                @click="activeStatus = false"
                                :class="!activeStatus ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-slate-300 bg-white text-slate-500 hover:border-slate-400 hover:text-slate-700'"
                                class="inline-flex items-center gap-3 rounded-xl border px-4 py-2 text-sm font-medium transition">
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
                               class="w-full rounded-xl border border-slate-300 px-4 py-3 pr-12 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                        <button type="button"
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-3 flex items-center text-slate-400 transition hover:text-slate-600">
                            <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15.5A3.5 3.5 0 1012 8.5a3.5 3.5 0 000 7z" />
                            </svg>
                            <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3l18 18" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.584 10.587A2 2 0 0013.414 13.4" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.88 5.09A9.77 9.77 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.784 9.784 0 01-4.207 5.145M6.228 6.226A9.777 9.777 0 002.458 12c1.274 4.057 5.065 7 9.542 7a9.77 9.77 0 005.09-1.426" />
                            </svg>
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
    @endcan
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
