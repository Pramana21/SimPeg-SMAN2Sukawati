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

        $prefix = $kelas === 'X' ? 'E' : 'F.P';

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
            $request->validate([
                'nama_siswa' => ['required', 'string', 'max:255'],
                'nis' => ['required', 'string', 'max:50'],
                'nik' => ['required', 'string', 'max:50'],
                'nisn' => ['required', 'string', 'max:50'],
                'tanggal_lahir' => ['required', 'date'],
                'jenis_kelamin' => ['required', 'string'],
                'kelas' => ['required', 'string'],
                'alamat' => ['nullable', 'string'],
                'email' => ['nullable', 'email'],
                'no_hp' => ['nullable', 'string', 'max:20'],
                'nama_ibu_kandung' => ['nullable', 'string', 'max:255'],
            ]);

            $kategoriKelas = $this->buildKategoriKelas($request->kelas, $request->nomor_kelas);

            $fotoPath = null;

            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('siswa', 'public');
            }

            $murid = Siswa::create([
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

            $this->logActivity(
                'Murid',
                'Tambah Data',
                'Menambahkan data murid: ' . $murid->nama_siswa
            );

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
        $request->validate([
            'nama_siswa' => ['required', 'string', 'max:255'],
            'nis' => ['required', 'string', 'max:50'],
            'nik' => ['required', 'string', 'max:50'],
            'nisn' => ['required', 'string', 'max:50'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'string'],
            'kelas' => ['required', 'string'],
            'alamat' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'nama_ibu_kandung' => ['nullable', 'string', 'max:255'],
        ]);
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

        $this->logActivity(
            'Murid',
            'Edit Data',
            'Memperbarui data murid: ' . $murid->nama_siswa
        );

        return redirect()->route('murid.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $murid = Siswa::findOrFail($id);
        $namaMurid = $murid->nama_siswa;

        // hapus foto jika ada
        if ($murid->foto_path && Storage::disk('public')->exists($murid->foto_path)) {
            Storage::disk('public')->delete($murid->foto_path);
        }

        // hapus data
        $murid->delete();

        $this->logActivity(
            'Murid',
            'Hapus Data',
            'Menghapus data murid: ' . $namaMurid
        );

        return redirect()->route('murid.index')->with('success', 'Data berhasil dihapus');
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:siswa,id_siswa'],
        ]);

        $muridList = Siswa::whereIn('id_siswa', $validated['ids'])->get();

        foreach ($muridList as $murid) {
            if ($murid->foto_path && Storage::disk('public')->exists($murid->foto_path)) {
                Storage::disk('public')->delete($murid->foto_path);
            }

            $murid->delete();
        }

        $this->logActivity(
            'Murid',
            'Hapus Data',
            'Menghapus ' . count($validated['ids']) . ' data murid sekaligus'
        );

        return redirect()->back()->with('success', count($validated['ids']) . ' data murid berhasil dihapus');
    }
}
