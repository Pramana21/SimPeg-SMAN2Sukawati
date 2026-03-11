<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\DokumenPegawai;
use App\Models\Inventaris;

class DashboardController extends Controller
{

    public function index()
    {

        $totalPegawai = Pegawai::count();
        $totalDokumen = DokumenPegawai::count();
        $totalInventaris = Inventaris::count();

        return view('dashboard.index', compact(
            'totalPegawai',
            'totalDokumen',
            'totalInventaris'
        ));
    }

}