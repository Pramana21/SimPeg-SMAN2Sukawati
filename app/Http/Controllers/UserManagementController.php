<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = [
            [
                'username' => 'superadmin',
                'role' => 'Super Admin',
                'status' => 'Aktif'
            ],
            [
                'username' => 'admin_kepeg',
                'role' => 'Admin Kepegawaian',
                'status' => 'Aktif'
            ],
            [
                'username' => 'viewer',
                'role' => 'Viewer',
                'status' => 'Aktif'
            ],
            [
                'username' => 'siswa',
                'role' => 'Siswa',
                'status' => 'Aktif'
            ],
        ];

        return view('admin.users.index', compact('users'));
    }
}