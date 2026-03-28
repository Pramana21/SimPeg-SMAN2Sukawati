<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    public function index()
    {
        $data = Pegawai::latest()->get();
        return view('admin.data-center.pegawai.index', compact('data'));
    }

    public function create()
    {
        return view('admin.data-center.pegawai.create');
    }

    public function store(Request $request)
    {
        try {

            $fotoPath = null;

            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('pegawai', 'public');
            }

            Pegawai::create([
                'nama_pegawai' => $request->nama_pegawai,
                'nip' => $request->nip,
                'nik' => $request->nik,
                'nuptk' => $request->nuptk,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'status_pegawai' => $request->status_pegawai,
                'pendidikan_terakhir' => $request->pendidikan,
                'alamat' => $request->alamat,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'foto_path' => $fotoPath,
            ]);

            return redirect()->route('pegawai.index')->with('success', 'Data berhasil disimpan');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function show($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return view('admin.data-center.pegawai.show', compact('pegawai'));
    }

    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return view('admin.data-center.pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        // upload foto baru
        if ($request->hasFile('foto')) {

            // hapus foto lama
            if ($pegawai->foto_path && Storage::disk('public')->exists($pegawai->foto_path)) {
                Storage::disk('public')->delete($pegawai->foto_path);
            }

            $fotoPath = $request->file('foto')->store('pegawai', 'public');
            $pegawai->foto_path = $fotoPath;
        }

        $pegawai->update([
            'nama_pegawai' => $request->nama_pegawai,
            'nip' => $request->nip,
            'nik' => $request->nik,
            'nuptk' => $request->nuptk,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'status_pegawai' => $request->status_pegawai,
            'pendidikan_terakhir' => $request->pendidikan,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        // hapus foto
        if ($pegawai->foto_path && Storage::disk('public')->exists($pegawai->foto_path)) {
            Storage::disk('public')->delete($pegawai->foto_path);
        }

        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Data berhasil dihapus');
    }
}