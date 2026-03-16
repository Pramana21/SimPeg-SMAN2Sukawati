<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create([
            'role_name' => 'Super Admin',
            'description' => 'Akses penuh ke seluruh sistem',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Role::create([
            'role_name' => 'Admin Kepegawaian',
            'description' => 'Mengelola data pegawai dan dokumen',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Role::create([
            'role_name' => 'Tamu',
            'description' => 'Hanya dapat melihat dokumen',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Role::create([
            'role_name' => 'Siswa',
            'description' => 'Akses terbatas untuk siswa',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}