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
            'description' => 'Akses penuh ke seluruh sistem'
        ]);

        Role::create([
            'role_name' => 'Admin',
            'description' => 'Mengelola data dan dokumen'
        ]);

        Role::create([
            'role_name' => 'Viewer',
            'description' => 'Hanya dapat melihat dokumen'
        ]);
    }
}
