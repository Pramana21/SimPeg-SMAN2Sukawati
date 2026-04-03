@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-4xl font-semibold text-slate-900">Edit Pengguna</h1>
        <p class="mt-2 text-sm text-slate-500">Perbarui username, role, status, dan password pengguna.</p>
    </div>

    @if(session('success'))
        <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="max-w-3xl rounded-[28px] border border-slate-200 bg-white/90 p-6 shadow-sm">
        <form method="POST" action="{{ route('users.update', $user->id_user) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="space-y-2">
                <label for="username" class="text-sm font-semibold text-slate-700">Username</label>
                <input id="username"
                       name="username"
                       type="text"
                       value="{{ old('username', $user->username) }}"
                       class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
            </div>

            <div class="space-y-2">
                <label for="role_id" class="text-sm font-semibold text-slate-700">Role</label>
                <select id="role_id"
                        name="role_id"
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id_role }}" {{ (string) old('role_id', $user->id_role) === (string) $role->id_role ? 'selected' : '' }}>
                            {{ $role->role_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-2">
                <label for="status" class="text-sm font-semibold text-slate-700">Status</label>
                <select id="status"
                        name="status"
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                    <option value="1" {{ old('status', $user->is_active ? '1' : '0') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('status', $user->is_active ? '1' : '0') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="space-y-2">
                <label for="password" class="text-sm font-semibold text-slate-700">Password Baru</label>
                <input id="password"
                       name="password"
                       type="password"
                       placeholder="Kosongkan jika tidak ingin mengubah password"
                       class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
            </div>

            <div class="flex items-center justify-end gap-3 border-t border-slate-200 pt-5">
                <a href="{{ route('users.index') }}"
                   class="inline-flex items-center rounded-lg border border-blue-200 px-4 py-2.5 text-sm font-semibold text-blue-600 transition hover:border-blue-300 hover:bg-blue-50">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
