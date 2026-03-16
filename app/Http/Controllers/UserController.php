<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Role;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $users = User::with(['role','pegawai'])->get();

    return view('admin.user.index', compact('users'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $roles = Role::all();
    $pegawai = Pegawai::all();

    return view('admin.user.create', compact('roles','pegawai'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'username' => 'required|unique:users,username',
        'password_hash' => 'required',
        'id_role' => 'required',
    ]);

    User::create([
        'username' => $request->username,
        'password_hash' => bcrypt($request->password_hash),
        'id_role' => $request->id_role,
        'id_pegawai' => $request->id_pegawai,
        'is_active' => true
    ]);

    return redirect()->route('user.index')
        ->with('success','User berhasil dibuat');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $user = User::findOrFail($id);
    $roles = Role::all();
    $pegawai = Pegawai::all();

    return view('admin.user.edit', compact('user','roles','pegawai'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $user->update([
        'username' => $request->username,
        'id_role' => $request->id_role,
        'id_pegawai' => $request->id_pegawai,
        'is_active' => $request->is_active
    ]);

    return redirect()->route('user.index')
        ->with('success','User berhasil diperbarui');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('user.index')
        ->with('success','User berhasil dihapus');
}
}
