<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataCenterController extends Controller
{
    public function index()
    {
        return view('admin.data-center.index', [
            'title' => 'Data Center'
        ]);
    }
}