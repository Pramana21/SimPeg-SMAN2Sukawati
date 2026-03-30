<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->updateOrInsert(
            ['username' => 'admin'],
            [
                'password_hash' => Hash::make('admin123'),
                'id_role' => 1,
                'is_active' => true,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}
