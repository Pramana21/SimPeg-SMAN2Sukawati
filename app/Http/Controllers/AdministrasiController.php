<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DokumenAdministrasi;
use App\Models\JenisDokumenAdministrasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdministrasiController extends Controller
{
    // =========================
    // INDEX (LIST DATA)
    // =========================
    public function index(Request $request)
    {
        $query = DokumenAdministrasi::with('jenis.kategori');

        // 🔹 FILTER KATEGORI (Pegawai / Siswa)
        if ($request->kategori) {
            $query->whereHas('jenis.kategori', function ($q) use ($request) {
                $q->where('nama_kategori', $request->kategori);
            });
        }

        // 🔹 FILTER BULAN
        if ($request->bulan) {
            $query->whereMonth('tanggal_dokumen', $request->bulan);
        }

        // 🔹 FILTER TAHUN
        if ($request->tahun) {
            $query->whereYear('tanggal_dokumen', $request->tahun);
        }

        $data = $query->latest()->paginate(10);

        return view('admin.administrasi.index', compact('data'));
    }

    // =========================
    // FORM CREATE
    // =========================
    public function create()
    {
        $jenis = JenisDokumenAdministrasi::with('kategori')->get();

        return view('admin.administrasi.create', compact('jenis'));
    }

    // =========================
    // STORE (UPLOAD FILE)
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'nama_dokumen' => 'required',
            'tanggal_dokumen' => 'required|date',
            'id_jenis_dokumen_administrasi' => 'required',
            'file_surat' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,png|max:2048'
        ]);

        // upload file
        $file = $request->file('file_surat');
        $path = $file->store('administrasi', 'public');

        DokumenAdministrasi::create([
            'id_user' => Auth::id(),
            'nama_dokumen' => $request->nama_dokumen,
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'id_jenis_dokumen_administrasi' => $request->id_jenis_dokumen_administrasi,
            'file_path' => $path,
            'created_by' => Auth::user()->username ?? 'Admin',
            'bulan' => date('m', strtotime($request->tanggal_dokumen)),
            'tahun' => date('Y', strtotime($request->tanggal_dokumen)),
        ]);

        return redirect('/administrasi')->with('success', 'Data berhasil ditambahkan');
    }

    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {
        $data = DokumenAdministrasi::findOrFail($id);

        if ($data->file_path && Storage::disk('public')->exists($data->file_path)) {
            Storage::disk('public')->delete($data->file_path);
        }

        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}