<?php

namespace App\Http\Controllers;

use App\Models\DokumenKeuangan;
use App\Models\KategoriKeuangan;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    // OVERVIEW
    public function index(Request $request)
    {
        $query = DokumenKeuangan::with('kategori');

        if ($request->bulan) {
            $query->where('bulan', $request->bulan);
        }

        if ($request->tahun) {
            $query->where('tahun', $request->tahun);
        }

        $data = $query->latest()->paginate(10);

        return view('admin.keuangan.index', [
            'data' => $data,
            'title' => 'Overview Keuangan'
        ]);
    }

    // 🔥 INI YANG WAJIB ADA (PENGGANTI byKategori)
    public function show(Request $request, $slug)
    {
        $kategori = KategoriKeuangan::where('slug', $slug)->firstOrFail();

        $query = DokumenKeuangan::with('kategori')
            ->where('id_kategori_keuangan', $kategori->id);

        if ($request->bulan) {
            $query->where('bulan', $request->bulan);
        }

        if ($request->tahun) {
            $query->where('tahun', $request->tahun);
        }

        $data = $query->latest()->paginate(10);

        return view('admin.keuangan.kategori', [
            'data' => $data,
            'kategori' => $kategori, // 🔥 PENTING
            'title' => $kategori->nama_kategori
        ]);
    }

    public function create($slug)
    {
        $kategori = KategoriKeuangan::where('slug', $slug)->firstOrFail();

        return view('admin.keuangan.create', [
            'kategori' => $kategori,
            'slug' => $slug
        ]);
    }

    public function store(Request $request, $slug)
    {
        $kategori = KategoriKeuangan::where('slug', $slug)->firstOrFail();

        $request->validate([
            'nama_dokumen' => 'required',
            'tanggal_dokumen' => 'required|date',
            'created_by' => 'required|string|max:255', // 🔥 WAJIB
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx'
        ]);

        $file = $request->file('file');
        $path = $file->store('keuangan', 'public');

        DokumenKeuangan::create([
            'nama_dokumen' => $request->nama_dokumen,
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'id_kategori_keuangan' => $kategori->id,

            // 🔥 FIX UTAMA
            'created_by' => $request->created_by,

            'file_path' => $path,
            'bulan' => date('m', strtotime($request->tanggal_dokumen)),
            'tahun' => date('Y', strtotime($request->tanggal_dokumen)),

            // optional (kalau masih dipakai)
            'id_user' => auth()->id()
        ]);

        return redirect()->route('keuangan.kategori', $slug)
            ->with('success', 'Dokumen berhasil diupload');
    }
}