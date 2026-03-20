<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
        public function index($id = null)
        {
            $roles = Role::all();

            $selectedRole = $id 
                ? Role::find($id) 
                : $roles->first();

            // 🔥 DATA BERBEDA TIAP ROLE
            $rolePermissions = [];

            if ($selectedRole->role_name == 'Super Admin') {

                $rolePermissions = [
                    'modules' => [
                        'Dashboard','Role Akses','Manajemen User','Audit Log',
                        'Penyuratan','Keuangan','Inventaris','Data Center','Administrasi Umum'
                    ],
                    'actions' => [
                        'Kelola data (Tambah/Ubah/Hapus)',
                        'Lihat detail',
                        'Unduh dokumen'
                    ]
                ];

            } elseif ($selectedRole->role_name == 'Admin Kepegawaian') {

                $rolePermissions = [
                    'modules' => [
                        'Dashboard','Penyuratan','Keuangan','Inventaris','Data Center','Administrasi Umum'
                    ],
                    'actions' => [
                        'Kelola data (Tambah/Ubah/Hapus)',
                        'Lihat detail',
                        'Unduh dokumen'
                    ]
                ];

            } elseif ($selectedRole->role_name == 'Tamu') {

                $rolePermissions = [
                    'modules' => [
                        'Dashboard','Penyuratan','Keuangan','Inventaris','Data Center','Administrasi Umum'
                    ],
                    'actions' => [
                        'Lihat detail'
                    ]
                ];

            } elseif ($selectedRole->role_name == 'Siswa') {

                $rolePermissions = [
                    'modules' => [
                        'Administrasi Umum'
                    ],
                    'actions' => [
                        'Kelola data (Tambah/Ubah/Hapus)',
                        'Lihat detail',
                        'Unduh dokumen'
                    ]
                ];
            }

            return view('admin.roles.index', compact(
                'roles',
                'selectedRole',
                'rolePermissions'
            ));
        }
}




