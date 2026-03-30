<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'role_name' => 'Super Admin',
                'description' => 'Akses penuh ke seluruh sistem',
            ],
            [
                'role_name' => 'Admin Kepegawaian',
                'description' => 'Mengelola data pegawai dan dokumen',
            ],
            [
                'role_name' => 'Tamu',
                'description' => 'Hanya dapat melihat dokumen',
            ],
            [
                'role_name' => 'Siswa',
                'description' => 'Akses terbatas untuk siswa',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['role_name' => $role['role_name']],
                ['description' => $role['description']]
            );
        }
    }
}
