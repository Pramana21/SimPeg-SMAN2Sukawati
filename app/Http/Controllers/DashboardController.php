<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\DokumenAdministrasi;
use App\Models\DokumenInventaris;
use App\Models\DokumenKeuangan;
use App\Models\DokumenPenyuratan;
use App\Models\User;
use App\Models\Siswa;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUser = User::count();
        $totalDokumen =
            DokumenAdministrasi::count() +
            DokumenKeuangan::count() +
            DokumenPenyuratan::count() +
            DokumenInventaris::count();
        $totalStaff = User::count();
        $totalSiswa = Siswa::count();

        try {
            $logs = AuditLog::with('user')
                ->latest()
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            $logs = collect();
        }

        if ($logs->isEmpty()) {
            $logs = collect();
        }

        return view('admin.dashboard.index', compact(
            'totalUser',
            'totalDokumen',
            'totalStaff',
            'totalSiswa',
            'logs'
        ));
    }
}
