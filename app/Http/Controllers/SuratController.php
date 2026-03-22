<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DokumenPenyuratan;
use App\Models\JenisSurat;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratController extends Controller
{
    public function index(Request $request)
    {
        $query = DokumenPenyuratan::with('jenis');

        // 🔹 FILTER JENIS
        if ($request->jenis) {
            $query->whereHas('jenis', function ($q) use ($request) {
                $q->where('nama_jenis_surat', ucfirst($request->jenis));
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
        
        $surat = $query
            ->latest()
            ->paginate(10);

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

        public function edit($id)
    {
        $surat = DokumenPenyuratan::findOrFail($id);
        $jenis = JenisSurat::all();

        return view('admin.penyuratan.edit', compact('surat', 'jenis'));
    }

    public function update(Request $request, $id)
    {
        $data = DokumenPenyuratan::findOrFail($id);

        $request->validate([
            'no_surat' => 'required|unique:dokumen_penyuratan,no_surat,' . $id . ',id_dokumen_penyuratan',
            'nama_dokumen' => 'required',
            'tanggal_dokumen' => 'required|date',
            'id_jenis_surat' => 'required',
        ]);

        // cek kalau upload file baru
        if ($request->hasFile('file_surat')) {

            // hapus file lama
            if ($data->file_path && \Storage::disk('public')->exists($data->file_path)) {
                \Storage::disk('public')->delete($data->file_path);
            }

            $file = $request->file('file_surat');
            $path = $file->store('surat', 'public');

            $data->file_path = $path;
    }

        // update data
        $data->update([
            'nama_dokumen' => $request->nama_dokumen,
            'no_surat' => $request->no_surat,
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'id_jenis_surat' => $request->id_jenis_surat,
            'nama_pengirim_penerima' => $request->nama_pengirim_penerima,
            'bulan' => date('m', strtotime($request->tanggal_dokumen)),
            'tahun' => date('Y', strtotime($request->tanggal_dokumen)),
        ]);

        return redirect('/penyuratan')->with('success', 'Data berhasil diupdate');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'no_surat' => 'required|unique:dokumen_penyuratan,no_surat',
            'nama_dokumen' => 'required',
            'tanggal_dokumen' => 'required|date',
            'id_jenis_surat' => 'required',
            'file_surat' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,png|max:2048'
        ]);

        // 🔥 ambil user login (AMAN)
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User belum login');
        }

        $file = $request->file('file_surat');
        $path = $file->store('surat', 'public');

        DokumenPenyuratan::create([
            'id_user' => $user->id_user, // ✅ FIX TOTAL
            'nama_dokumen' => $request->nama_dokumen,
            'no_surat' => $request->no_surat,
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'id_jenis_surat' => $request->id_jenis_surat,
            'nama_pengirim_penerima' => $request->nama_pengirim_penerima,
            'file_path' => $path,
            'created_by' => $user->username, // ✅ sesuai DB kamu
            'bulan' => date('m', strtotime($request->tanggal_dokumen)),
            'tahun' => date('Y', strtotime($request->tanggal_dokumen)),
        ]);

        return redirect('/penyuratan')->with('success', 'Surat berhasil ditambahkan');
    }

    public function exportPdf()
    {
        $surat = DokumenPenyuratan::with('jenis')->get();

        $pdf = Pdf::loadView('admin.surat.pdf', compact('surat'));

        return $pdf->download('laporan_surat.pdf');
    }
}