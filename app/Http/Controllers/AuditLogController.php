<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function index(Request $request): View
    {
        $selectedBulan = $request->filled('bulan') ? (int) $request->query('bulan') : null;
        $selectedTahun = $request->filled('tahun') ? (int) $request->query('tahun') : null;

        $logs = AuditLog::with(['user.pegawai'])
            ->when($selectedBulan, function ($query) use ($selectedBulan) {
                $query->whereMonth('created_at', $selectedBulan);
            })
            ->when($selectedTahun, function ($query) use ($selectedTahun) {
                $query->whereYear('created_at', $selectedTahun);
            })
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $months = collect(range(1, 12))
            ->mapWithKeys(fn (int $month) => [$month => Carbon::create()->month($month)->locale('id')->translatedFormat('F')]);

        $currentYear = (int) now()->year;
        $years = range($currentYear, 2020);

        return view('admin.audit-log.index', [
            'logs' => $logs,
            'months' => $months,
            'years' => $years,
            'selectedBulan' => $selectedBulan,
            'selectedTahun' => $selectedTahun,
        ]);
    }

    public function export(Request $request)
    {
        $selectedBulan = $request->filled('bulan') ? (int) $request->query('bulan') : null;
        $selectedTahun = $request->filled('tahun') ? (int) $request->query('tahun') : null;

        $logs = AuditLog::with(['user.pegawai'])
            ->when($selectedBulan, function ($query) use ($selectedBulan) {
                $query->whereMonth('created_at', $selectedBulan);
            })
            ->when($selectedTahun, function ($query) use ($selectedTahun) {
                $query->whereYear('created_at', $selectedTahun);
            })
            ->latest()
            ->get();

        $filename = 'audit_log.csv';
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($logs) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Tanggal', 'Pengguna', 'Modul', 'Aktivitas', 'Keterangan']);

            foreach ($logs as $log) {
                fputcsv($file, [
                    optional($log->created_at)->format('d-m-Y H:i'),
                    $log->user?->pegawai?->nama_pegawai ?? $log->user?->username ?? $log->nama_pengguna ?? '-',
                    $log->modul,
                    $log->aktivitas,
                    $log->keterangan,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('selected_ids');

        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'Pilih data terlebih dahulu');
        }

        AuditLog::whereIn('id', $ids)->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
