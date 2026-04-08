<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $auditLogPermissionIds = DB::table('permissions')
            ->where('module', 'audit_log')
            ->pluck('id_permission');

        if ($auditLogPermissionIds->isEmpty()) {
            return;
        }

        $nonSuperAdminRoleIds = DB::table('roles')
            ->where('role_name', '!=', 'Super Admin')
            ->pluck('id_role');

        if ($nonSuperAdminRoleIds->isEmpty()) {
            return;
        }

        DB::table('role_permissions')
            ->whereIn('id_role', $nonSuperAdminRoleIds)
            ->whereIn('id_permission', $auditLogPermissionIds)
            ->delete();
    }

    public function down(): void
    {
        $auditLogPermissionId = DB::table('permissions')
            ->where('module', 'audit_log')
            ->where('action', 'view')
            ->value('id_permission');

        if (!$auditLogPermissionId) {
            return;
        }

        $timestamp = now();

        $roleIds = DB::table('roles')
            ->whereIn('role_name', ['Admin Kepegawaian', 'Tamu'])
            ->pluck('id_role');

        foreach ($roleIds as $roleId) {
            DB::table('role_permissions')->updateOrInsert(
                [
                    'id_role' => $roleId,
                    'id_permission' => $auditLogPermissionId,
                ],
                [
                    'updated_at' => $timestamp,
                    'created_at' => $timestamp,
                ]
            );
        }
    }
};
