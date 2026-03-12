<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {

        // sementara gunakan data dummy dulu
        $totalUser = 0;
        $totalDokumen = 0;
        $totalStaff = 0;
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