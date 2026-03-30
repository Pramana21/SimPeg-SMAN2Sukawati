<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MuridController extends Controller
{
    private function buildKategoriKelas(?string $kelas, ?string $nomorKelas): ?string
    {
        if (!$kelas || !$nomorKelas) {
            return null;
        }

        $prefix = $kelas === 'X' ? 'E' : 'F';

        return $prefix . ' - ' . $nomorKelas;
    }

    public function index()
    {
        $data = Siswa::latest()->get();
        return view('admin.data-center.murid.index', compact('data'));
    }

    public function create()
    {
        return view('admin.data-center.murid.create');
    }

    public function store(Request $request)
    {
        try {
            $kategoriKelas = $this->buildKategoriKelas($request->kelas, $request->nomor_kelas);

            $fotoPath = null;

            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('siswa', 'public');
            }

            Siswa::create([
                'nama_siswa' => $request->nama_siswa,
                'nis' => $request->nis,
                'nisn' => $request->nisn,
                'nik' => $request->nik,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'nama_ibu_kandung' => $request->nama_ibu_kandung,
                'foto_path' => $fotoPath,
                'kelas' => $request->kelas,
                'kategori_kelas' => $kategoriKelas,
            ]);

            return redirect()->route('murid.index')->with('success', 'Data berhasil disimpan');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function show($id)
    {
        $murid = Siswa::findOrFail($id);
        return view('admin.data-center.murid.show', compact('murid'));
    }

    public function edit($id)
    {
        $murid = Siswa::findOrFail($id);
        return view('admin.data-center.murid.edit', compact('murid'));
    }

    public function update(Request $request, $id)
    {
        $murid = Siswa::findOrFail($id);
        $kategoriKelas = $this->buildKategoriKelas($request->kelas, $request->nomor_kelas);

        // upload foto baru (optional)
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('siswa', 'public');
            $murid->foto_path = $fotoPath;
        }

        $murid->update([
            'nama_siswa' => $request->nama_siswa,
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'nama_ibu_kandung' => $request->nama_ibu_kandung,
            'kelas' => $request->kelas,
            'kategori_kelas' => $kategoriKelas,
        ]);

        return redirect()->route('murid.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $murid = Siswa::findOrFail($id);

        // hapus foto jika ada
        if ($murid->foto_path && Storage::disk('public')->exists($murid->foto_path)) {
            Storage::disk('public')->delete($murid->foto_path);
        }

        // hapus data
        $murid->delete();

        return redirect()->route('murid.index')->with('success', 'Data berhasil dihapus');
    }
}
