<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuratController extends Controller
{
    public function index()
    {
        $surat = [
            [
                'no' => 'SMAA27025',
                'nama' => 'Surat Direktur',
                'jenis' => 'Masuk',
                'pengirim' => 'Ni Luh Siti',
                'tanggal' => '25/01/2025',
                'admin' => 'Admin Penyuratan'
            ],
            [
                'no' => 'SMAA27025',
                'nama' => 'Surat Direktur',
                'jenis' => 'Keluar',
                'pengirim' => 'Ni Luh Siti',
                'tanggal' => '25/01/2025',
                'admin' => 'Admin Penyuratan'
            ],
        ];

        return view('admin.penyuratan.index', compact('surat'));
    }

    public function create()
    {
        return view('admin.penyuratan.create');
    }
}