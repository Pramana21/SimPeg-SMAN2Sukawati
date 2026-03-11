<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\DokumenPegawai;

class DokumenPegawaiController extends Controller
{
    public function index()
{
    $dokumen = DokumenPegawai::with('pegawai')->get();

    return view('dokumen.index', compact('dokumen'));
}
    public function create()
    {
        $pegawai = Pegawai::all();

        return view('dokumen.create', compact('pegawai'));
    }

    public function store(Request $request)
{

    $request->validate([
        'pegawai_id' => 'required',
        'nama_dokumen' => 'required',
        'file_dokumen' => 'required|file|mimes:pdf,jpg,png|max:2048'
    ]);

    $file = $request->file('file_dokumen');

    $namaFile = time().'_'.$file->getClientOriginalName();

    $file->move(public_path('dokumen'), $namaFile);

    DokumenPegawai::create([
        'pegawai_id' => $request->pegawai_id,
        'nama_dokumen' => $request->nama_dokumen,
        'file_dokumen' => $namaFile
    ]);

    return redirect('/dashboard');

}
    public function destroy($id)
{

    $dokumen = DokumenPegawai::findOrFail($id);

    unlink(public_path('dokumen/'.$dokumen->file_dokumen));

    $dokumen->delete();

    return redirect('/dokumen');

}
}