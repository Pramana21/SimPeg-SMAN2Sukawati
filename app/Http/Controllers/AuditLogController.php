<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
{
    // Ambil filter dari URL
    $bulan = $request->bulan;
    $tahun = $request->tahun;

    // Dummy data
    $logs = collect([
        [
            'tanggal' => '2025-01-22',
            'user' => 'Admin',
            'modul' => 'Adm. Umum',
            'aksi' => 'Tambah Dokumen',
            'keterangan' => 'Absensi Siswa kelas 10 E 1'
        ],
        [
            'tanggal' => '2025-01-21',
            'user' => 'Siswa',
            'modul' => 'Adm. Umum',
            'aksi' => 'Ubah Dokumen',
            'keterangan' => 'Jurnal Kelas 11 F P 2'
        ],
        [
            'tanggal' => '2025-02-10',
            'user' => 'Admin',
            'modul' => 'Keuangan',
            'aksi' => 'Hapus Dokumen',
            'keterangan' => 'Laporan Keuangan Maret'
        ],
    ]);

    // FILTER
    if ($bulan) {
        $logs = $logs->filter(function ($log) use ($bulan) {
            return date('m', strtotime($log['tanggal'])) == $bulan;
        });
    }

    if ($tahun) {
        $logs = $logs->filter(function ($log) use ($tahun) {
            return date('Y', strtotime($log['tanggal'])) == $tahun;
        });
    }

    return view('admin.audit-log.index', compact('logs', 'bulan', 'tahun'));
}
}