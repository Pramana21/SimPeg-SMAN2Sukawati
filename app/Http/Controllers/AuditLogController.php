<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index()
    {
        // sementara dummy (sesuai fase UI)
        $logs = [
            [
                'tanggal' => '22-12-2025',
                'user' => 'Admin',
                'modul' => 'Adm. Umum',
                'aksi' => 'Tambah Dokumen',
                'keterangan' => 'Absensi Siswa kelas 10 E 1'
            ],
            [
                'tanggal' => '22-12-2025',
                'user' => 'Siswa',
                'modul' => 'Adm. Umum',
                'aksi' => 'Ubah Dokumen',
                'keterangan' => 'Jurnal Kelas 11 F P 2'
            ],
            [
                'tanggal' => '22-12-2025',
                'user' => 'Admin',
                'modul' => 'Keuangan',
                'aksi' => 'Hapus Dokumen',
                'keterangan' => 'Laporan Keuangan Maret'
            ],
            [
                'tanggal' => '21-12-2025',
                'user' => 'Viewer',
                'modul' => 'Penyuratan',
                'aksi' => 'Lihat Dokumen',
                'keterangan' => 'Surat Masuk No. 123'
            ],
        ];

        return view('admin.audit-log.index', compact('logs'));
    }
}