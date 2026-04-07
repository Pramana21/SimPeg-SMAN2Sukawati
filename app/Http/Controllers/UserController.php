<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['role', 'pegawai'])
            ->orderBy('username')
            ->get();

        $roles = Role::orderBy('role_name')->get();

        return view('admin.user.index', compact('users', 'roles'));
    }

    public function create()
    {
        return redirect()->route('users.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:60', 'unique:users,username'],
            'role_id' => ['required', 'exists:roles,id_role'],
            'status' => ['required', 'in:0,1'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        User::create([
            'username' => $validated['username'],
            'password_hash' => Hash::make($validated['password']),
            'id_role' => $validated['role_id'],
            'is_active' => $this->normalizeStatus($validated['status']),
        ]);

        return redirect()->back()->with('success', 'User berhasil dibuat');
    }

    public function show(string $id)
    {
        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        $user = User::with('role')->findOrFail($id);
        $roles = Role::orderBy('role_name')->get();

        return view('admin.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:60',
                Rule::unique('users', 'username')->ignore($user->id_user, 'id_user'),
            ],
            'role_id' => ['required', 'exists:roles,id_role'],
            'status' => ['required', 'in:0,1'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $payload = [
            'username' => $validated['username'],
            'id_role' => $validated['role_id'],
            'is_active' => $this->normalizeStatus($validated['status']),
        ];

        if (!empty($validated['password'])) {
            $payload['password_hash'] = Hash::make($validated['password']);
        }

        $user->update($payload);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diperbarui');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'is_active' => !$user->is_active,
        ]);

        $message = $user->is_active
            ? 'User berhasil diaktifkan'
            : 'User berhasil dinonaktifkan';

        return redirect()->back()->with('success', $message);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus');
    }

    private function normalizeStatus($status): bool
    {
        return (string) $status === '1';
    }
}
