<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Auditlog;

class DashboardController extends Controller
{

    public function index()
    {

        // $totalUser = User::count();

        // $totalDokumen = 0; // sementara

        // $totalStaff = User::count();

        // $totalSiswa = Siswa::count();

        // $auditLogs = Auditlog::latest()
        //                 ->take(10)
        //                 ->get();
        $totalUser = User::count();

        $totalDokumen = 0;

        $totalStaff = User::count();

        $totalSiswa = 0;

        $auditLogs = [];

        return view('admin.dashboard.index', compact(
            'totalUser',
            'totalDokumen',
            'totalStaff',
            'totalSiswa',
            'auditLogs'
        ));

    }

}