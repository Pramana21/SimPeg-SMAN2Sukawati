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

public function export(Request $request)
{
    $bulan = $request->bulan;
    $tahun = $request->tahun;

    // data dummy (sementara)
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

    // FILTER (sama seperti index)
    if ($bulan) {
        $logs = $logs->filter(fn($log) =>
            date('m', strtotime($log['tanggal'])) == $bulan
        );
    }

    if ($tahun) {
        $logs = $logs->filter(fn($log) =>
            date('Y', strtotime($log['tanggal'])) == $tahun
        );
    }

    // EXPORT CSV
    $filename = "audit_log.csv";

    $headers = [
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
    ];

    $callback = function () use ($logs) {
        $file = fopen('php://output', 'w');

        // header kolom
        fputcsv($file, ['Tanggal', 'User', 'Modul', 'Aksi', 'Keterangan']);

        foreach ($logs as $log) {
            fputcsv($file, [
                $log['tanggal'],
                $log['user'],
                $log['modul'],
                $log['aksi'],
                $log['keterangan']
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}