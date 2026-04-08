<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissionMap = [
            'dashboard' => ['view'],
            'role_akses' => ['view', 'create', 'edit', 'delete'],
            'manajemen_user' => ['view', 'create', 'edit', 'delete'],
            'audit_log' => ['view'],
            'penyuratan' => ['view', 'create', 'edit', 'delete'],
            'keuangan' => ['view', 'create', 'edit', 'delete'],
            'inventaris' => ['view', 'create', 'edit', 'delete'],
            'data_center' => ['view', 'create', 'edit', 'delete'],
            'administrasi_umum' => ['view', 'create', 'edit', 'delete'],
            'administrasi_umum_pegawai' => ['view', 'create', 'edit', 'delete'],
            'administrasi_umum_siswa' => ['view', 'create', 'edit', 'delete'],
        ];

        foreach ($permissionMap as $module => $actions) {
            foreach ($actions as $action) {
                DB::table('permissions')->updateOrInsert(
                    [
                        'module' => $module,
                        'action' => $action,
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
