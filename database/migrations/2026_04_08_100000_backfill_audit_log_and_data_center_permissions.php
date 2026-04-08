<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $timestamp = now();

        $permissionMap = [
            'audit_log' => ['view'],
            'data_center' => ['view', 'create', 'edit', 'delete'],
        ];

        foreach ($permissionMap as $module => $actions) {
            foreach ($actions as $action) {
                DB::table('permissions')->updateOrInsert(
                    [
                        'module' => $module,
                        'action' => $action,
                    ],
                    [
                        'updated_at' => $timestamp,
                        'created_at' => $timestamp,
                    ]
                );
            }
        }

        $roles = DB::table('roles')
            ->whereIn('role_name', ['Super Admin', 'Admin Kepegawaian', 'Tamu'])
            ->pluck('id_role', 'role_name');

        $abilitiesByRole = [
            'Super Admin' => ['audit_log.view', 'data_center.view', 'data_center.create', 'data_center.edit', 'data_center.delete'],
            'Admin Kepegawaian' => ['data_center.view', 'data_center.create', 'data_center.edit', 'data_center.delete'],
            'Tamu' => ['data_center.view'],
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
        $modules = ['audit_log', 'data_center'];

        $permissionIds = DB::table('permissions')
            ->whereIn('module', $modules)
            ->pluck('id_permission');

        if ($permissionIds->isEmpty()) {
            return;
        }

        DB::table('role_permissions')
            ->whereIn('id_permission', $permissionIds)
            ->delete();

        DB::table('permissions')
            ->whereIn('module', $modules)
            ->delete();
    }
};
