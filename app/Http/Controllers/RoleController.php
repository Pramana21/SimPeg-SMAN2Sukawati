<?php

namespace App\Http\Controllers;

use App\Models\Role;

class RoleController extends Controller
{
    public function index($id = null)
    {
        $roles = Role::with('permissions')->orderBy('role_name')->get();

        $selectedRole = $id
            ? $roles->firstWhere('id_role', (int) $id)
            : $roles->first();

        abort_if(!$selectedRole, 404);

        $moduleLabels = [
            'dashboard' => 'Dashboard',
            'role_akses' => 'Role Akses',
            'manajemen_user' => 'Manajemen User',
            'audit_log' => 'Audit Log',
            'penyuratan' => 'Penyuratan',
            'keuangan' => 'Keuangan',
            'inventaris' => 'Inventaris',
            'data_center' => 'Data Center',
            'administrasi_umum' => 'Administrasi Umum',
            'administrasi_umum_pegawai' => 'Administrasi Umum - Pegawai',
            'administrasi_umum_siswa' => 'Administrasi Umum - Siswa',
        ];

        $actionLabels = [
            'view' => 'Lihat data',
            'create' => 'Tambah data',
            'edit' => 'Ubah data',
            'delete' => 'Hapus data',
        ];

        $rolePermissions = [
            'modules' => $selectedRole->permissions
                ->pluck('module')
                ->unique()
                ->map(fn ($module) => $moduleLabels[$module] ?? str($module)->replace('_', ' ')->title()->toString())
                ->values()
                ->all(),
            'actions' => $selectedRole->permissions
                ->pluck('action')
                ->unique()
                ->map(fn ($action) => $actionLabels[$action] ?? str($action)->replace('_', ' ')->title()->toString())
                ->values()
                ->all(),
        ];

        return view('admin.roles.index', compact(
            'roles',
            'selectedRole',
            'rolePermissions'
        ));
    }
}
