<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DokumenInventaris;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InventarisController extends Controller
{
    public function index(Request $request)
    {
        $query = DokumenInventaris::query();

        // FILTER BULAN
        if ($request->bulan) {
            $query->whereMonth('tanggal_dokumen', $request->bulan);
        }

        // FILTER TAHUN
        if ($request->tahun) {
            $query->whereYear('tanggal_dokumen', $request->tahun);
        }

        $data = $query->latest()->paginate(10);

        return view('admin.inventaris.index', compact('data'));
    }

    public function create()
    {
        return view('admin.inventaris.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_dokumen' => 'required',
            'tanggal_dokumen' => 'required|date',
            'file_surat' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,png|max:2048'
        ]);

        $file = $request->file('file_surat');
        $path = $file->store('inventaris', 'public');

        DokumenInventaris::create([
            'id_user' => Auth::user()->id_user,
            'nama_dokumen' => $request->nama_dokumen,
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'file_path' => $path,
            'created_by' => Auth::user()->username ?? 'Admin',
        ]);

        return redirect('/inventaris')->with('success', 'Data berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $data = DokumenInventaris::findOrFail($id);

        if ($data->file_path && Storage::disk('public')->exists($data->file_path)) {
            Storage::disk('public')->delete($data->file_path);
        }

        $data->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}