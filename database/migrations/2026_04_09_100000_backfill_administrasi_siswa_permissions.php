<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $timestamp = now();
        $actions = ['view', 'create', 'edit', 'delete'];

        foreach ($actions as $action) {
            DB::table('permissions')->updateOrInsert(
                [
                    'module' => 'administrasi_umum_siswa',
                    'action' => $action,
                ],
                [
                    'updated_at' => $timestamp,
                    'created_at' => $timestamp,
                ]
            );
        }

        $roles = DB::table('roles')
            ->whereIn('role_name', ['Admin Kepegawaian', 'Tamu'])
            ->pluck('id_role', 'role_name');

        $abilitiesByRole = [
            'Admin Kepegawaian' => [
                'administrasi_umum_siswa.view',
                'administrasi_umum_siswa.create',
                'administrasi_umum_siswa.edit',
                'administrasi_umum_siswa.delete',
            ],
            'Tamu' => [
                'administrasi_umum_siswa.view',
            ],
        ];

        foreach ($abilitiesByRole as $roleName => $abilities) {
            $roleId = $roles->get($roleName);

            if (!$roleId) {
                continue;
            }

            foreach ($abilities as $ability) {
                [$module, $action] = explode('.', $ability, 2);

                $permissionId = DB::table('permissions')
                    ->where('module', $module)
                    ->where('action', $action)
                    ->value('id_permission');

                if (!$permissionId) {
                    continue;
                }

                DB::table('role_permissions')->updateOrInsert(
                    [
                        'id_role' => $roleId,
                        'id_permission' => $permissionId,
                    ],
                    [
                        'updated_at' => $timestamp,
                        'created_at' => $timestamp,
                    ]
                );
            }
        }
    }

    public function down(): void
    {
        $permissionIds = DB::table('permissions')
            ->where('module', 'administrasi_umum_siswa')
            ->pluck('id_permission');

        if ($permissionIds->isEmpty()) {
            return;
        }

        $roleIds = DB::table('roles')
            ->whereIn('role_name', ['Admin Kepegawaian', 'Tamu'])
            ->pluck('id_role');

        if ($roleIds->isNotEmpty()) {
            DB::table('role_permissions')
                ->whereIn('id_role', $roleIds)
                ->whereIn('id_permission', $permissionIds)
                ->delete();
        }
    }
};
