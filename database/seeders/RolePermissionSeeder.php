<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = DB::table('roles')
            ->get()
            ->keyBy('role_name');

        $permissions = DB::table('permissions')
            ->get()
            ->keyBy(fn ($permission) => $permission->module . '.' . $permission->action);

        $permissionMap = [
            'Super Admin' => array_keys($permissions->all()),
            'Admin Kepegawaian' => [
                'dashboard.view',
                'penyuratan.view',
                'penyuratan.create',
                'penyuratan.edit',
                'penyuratan.delete',
                'keuangan.view',
                'keuangan.create',
                'keuangan.edit',
                'keuangan.delete',
                'inventaris.view',
                'inventaris.create',
                'inventaris.edit',
                'inventaris.delete',
                'data_center.view',
                'data_center.create',
                'data_center.edit',
                'data_center.delete',
                'administrasi_umum.view',
                'administrasi_umum.create',
                'administrasi_umum.edit',
                'administrasi_umum.delete',
                'administrasi_umum_pegawai.view',
                'administrasi_umum_pegawai.create',
                'administrasi_umum_pegawai.edit',
                'administrasi_umum_pegawai.delete',
                'administrasi_umum_siswa.view',
                'administrasi_umum_siswa.create',
                'administrasi_umum_siswa.edit',
                'administrasi_umum_siswa.delete',
            ],
            'Tamu' => [
                'dashboard.view',
                'role_akses.view',
                'manajemen_user.view',
                'penyuratan.view',
                'keuangan.view',
                'inventaris.view',
                'data_center.view',
                'administrasi_umum.view',
                'administrasi_umum_pegawai.view',
                'administrasi_umum_siswa.view',
            ],
            'Siswa' => [
                'dashboard.view',
                'administrasi_umum_siswa.view',
            ],
        ];

        foreach ($permissionMap as $roleName => $abilityList) {
            $role = $roles->get($roleName);

            if (!$role) {
                continue;
            }

            DB::table('role_permissions')
                ->where('id_role', $role->id_role)
                ->delete();

            foreach ($abilityList as $ability) {
                $permission = $permissions->get($ability);

                if (!$permission) {
                    continue;
                }

                DB::table('role_permissions')->updateOrInsert(
                    [
                        'id_role' => $role->id_role,
                        'id_permission' => $permission->id_permission,
                    ],
                    [
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        }
    }
}
