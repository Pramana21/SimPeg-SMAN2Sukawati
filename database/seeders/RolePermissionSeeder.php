<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = DB::table('roles')->get();
        $permissions = DB::table('permissions')->get();

        foreach ($roles as $role) {

            foreach ($permissions as $permission) {

                // Super Admin → semua akses
                if ($role->role_name == 'Super Admin') {
                    DB::table('role_permissions')->insert([
                        'id_role' => $role->id_role,
                        'id_permission' => $permission->id_permission,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }

                // Admin Kepegawaian → hanya pegawai & dokumen
                if ($role->role_name == 'Admin Kepegawaian') {
                    if (in_array($permission->module, [
                        'pegawai','penyuratan','keuangan','inventaris','administrasi'
                    ])) {
                        DB::table('role_permissions')->insert([
                            'id_role' => $role->id_role,
                            'id_permission' => $permission->id_permission,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }

                // Tamu → hanya view
                if ($role->role_name == 'Tamu') {
                    if ($permission->action == 'view') {
                        DB::table('role_permissions')->insert([
                            'id_role' => $role->id_role,
                            'id_permission' => $permission->id_permission,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }

                // Siswa → view siswa saja
                if ($role->role_name == 'Siswa') {
                    if ($permission->module == 'siswa' && $permission->action == 'view') {
                        DB::table('role_permissions')->insert([
                            'id_role' => $role->id_role,
                            'id_permission' => $permission->id_permission,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }
        }
    }
}