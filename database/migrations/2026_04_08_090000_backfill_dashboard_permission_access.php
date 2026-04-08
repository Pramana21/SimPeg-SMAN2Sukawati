<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $timestamp = now();

        DB::table('permissions')->updateOrInsert(
            [
                'module' => 'dashboard',
                'action' => 'view',
            ],
            [
                'updated_at' => $timestamp,
                'created_at' => $timestamp,
            ]
        );

        $dashboardPermissionId = DB::table('permissions')
            ->where('module', 'dashboard')
            ->where('action', 'view')
            ->value('id_permission');

        if (!$dashboardPermissionId) {
            return;
        }

        $allowedRoles = DB::table('roles')
            ->whereIn('role_name', ['Super Admin', 'Admin Kepegawaian', 'Tamu', 'Siswa'])
            ->pluck('id_role');

        foreach ($allowedRoles as $roleId) {
            DB::table('role_permissions')->updateOrInsert(
                [
                    'id_role' => $roleId,
                    'id_permission' => $dashboardPermissionId,
                ],
                [
                    'updated_at' => $timestamp,
                    'created_at' => $timestamp,
                ]
            );
        }
    }

    public function down(): void
    {
        $dashboardPermissionId = DB::table('permissions')
            ->where('module', 'dashboard')
            ->where('action', 'view')
            ->value('id_permission');

        if (!$dashboardPermissionId) {
            return;
        }

        $allowedRoles = DB::table('roles')
            ->whereIn('role_name', ['Super Admin', 'Admin Kepegawaian', 'Tamu', 'Siswa'])
            ->pluck('id_role');

        if ($allowedRoles->isNotEmpty()) {
            DB::table('role_permissions')
                ->whereIn('id_role', $allowedRoles)
                ->where('id_permission', $dashboardPermissionId)
                ->delete();
        }

        $stillUsed = DB::table('role_permissions')
            ->where('id_permission', $dashboardPermissionId)
            ->exists();

        if (!$stillUsed) {
            DB::table('permissions')
                ->where('id_permission', $dashboardPermissionId)
                ->delete();
        }
    }
};
