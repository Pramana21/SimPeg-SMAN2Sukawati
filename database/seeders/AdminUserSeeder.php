<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::query()->updateOrCreate(
            ['username' => 'admin'],
            [
                'password_hash' => Hash::make('admin123'),
                'id_role' => 1,
                'is_active' => true,
            ]
        );
    }
}
