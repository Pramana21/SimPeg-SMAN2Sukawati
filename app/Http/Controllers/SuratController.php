<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DokumenPenyuratan;
use App\Models\JenisSurat;
use Illuminate\Support\Facades\Auth;

class SuratController extends Controller
{
    public function index(Request $request)
{
    $query = DokumenPenyuratan::with('jenis');

        // FILTER JENIS
        if ($request->jenis == 'masuk') {
            $query->whereHas('jenis', function ($q) {
                $q->where('nama_jenis_surat', 'Masuk');
            });
        }

        if ($request->jenis == 'keluar') {
            $query->whereHas('jenis', function ($q) {
                $q->where('nama_jenis_surat', 'Keluar');
            });
        }

        $surat = $query->latest()->get();

        return view('admin.penyuratan.index', compact('surat'));
    }

    public function create()
    {
        $jenis = JenisSurat::all();

        return view('admin.penyuratan.create', compact('jenis'));
    }
    
    public function destroy($id)
    {
        $data = DokumenPenyuratan::findOrFail($id);

        // hapus file
        if ($data->file_path && \Storage::disk('public')->exists($data->file_path)) {
            \Storage::disk('public')->delete($data->file_path);
        }

        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_surat' => 'required|unique:dokumen_penyuratan,no_surat',
            'nama_dokumen' => 'required',
            'tanggal_dokumen' => 'required|date',
            'id_jenis_surat' => 'required',
            'file_surat' => 'required|file|mimes:pdf,doc,docx'
        ]);

        // upload file
        $file = $request->file('file_surat');
        $path = $file->store('surat', 'public');

        DokumenPenyuratan::create([
            'id_user' => Auth::id(),
            'nama_dokumen' => $request->nama_dokumen,
            'no_surat' => $request->no_surat,
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'id_jenis_surat' => $request->id_jenis_surat,
            'nama_pengirim_penerima' => $request->nama_pengirim_penerima,
            'file_path' => $path,
            'created_by' => Auth::user()->name ?? 'Admin',
            'bulan' => date('m', strtotime($request->tanggal_dokumen)),
            'tahun' => date('Y', strtotime($request->tanggal_dokumen)),
        ]);

        return redirect('/penyuratan')->with('success', 'Surat berhasil ditambahkan');
    }
}