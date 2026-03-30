<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            'pegawai',
            'siswa',
            'penyuratan',
            'keuangan',
            'inventaris',
            'administrasi',
            'user',
            'role'
        ];

        $actions = [
            'view',
            'create',
            'edit',
            'delete',
            'export',
            'approve',
            'reject',
            'upload',
            'download'
        ];

        foreach ($modules as $module) {
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
