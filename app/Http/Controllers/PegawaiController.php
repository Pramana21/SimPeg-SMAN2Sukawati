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
        return view('admin.data-center.pegawai.create', [
            'data' => null,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_pegawai' => ['required', 'string', 'max:255'],
                'nip' => ['nullable', 'string', 'max:50'],
                'nik' => ['required', 'string', 'max:50'],
                'nuptk' => ['nullable', 'string', 'max:50'],
                'tanggal_lahir' => ['required', 'date'],
                'jenis_kelamin' => ['required', 'string'],
                'status_pegawai' => ['required', 'string'],
                'pendidikan_terakhir' => ['nullable', 'string', 'max:255'],
                'alamat' => ['nullable', 'string'],
                'email' => ['nullable', 'email'],
                'no_hp' => ['nullable', 'string', 'max:20'],
                'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            ]);

            $fotoPath = null;

            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('pegawai', 'public');
            }

            $pegawai = Pegawai::create([
                'nama_pegawai' => $validated['nama_pegawai'],
                'nip_nippk' => $validated['nip'] ?? null,
                'nik' => $validated['nik'] ?? null,
                'nuptk' => $validated['nuptk'] ?? null,
                'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
                'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
                'status_pegawai' => $validated['status_pegawai'] ?? null,
                'pendidikan_terakhir' => $validated['pendidikan_terakhir'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
                'email' => $validated['email'] ?? null,
                'no_hp' => $validated['no_hp'] ?? null,
                'foto_path' => $fotoPath,
            ]);

            $this->logActivity(
                'Pegawai',
                'Tambah Data',
                'Menambahkan data pegawai: ' . $pegawai->nama_pegawai
            );

            return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil disimpan');

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
        return view('admin.data-center.pegawai.create', [
            'data' => $pegawai,
        ]);
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $validated = $request->validate([
            'nama_pegawai' => ['required', 'string', 'max:255'],
            'nip' => ['nullable', 'string', 'max:50'],
            'nik' => ['required', 'string', 'max:50'],
            'nuptk' => ['nullable', 'string', 'max:50'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'string'],
            'status_pegawai' => ['required', 'string'],
            'pendidikan_terakhir' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        // upload foto baru
        $fotoPath = $pegawai->foto_path;
        if ($request->hasFile('foto')) {

            // hapus foto lama
            if ($pegawai->foto_path && Storage::disk('public')->exists($pegawai->foto_path)) {
                Storage::disk('public')->delete($pegawai->foto_path);
            }

            $fotoPath = $request->file('foto')->store('pegawai', 'public');
        }

        $pegawai->update([
            'nama_pegawai' => $validated['nama_pegawai'],
            'nip_nippk' => $validated['nip'] ?? null,
            'nik' => $validated['nik'] ?? null,
            'nuptk' => $validated['nuptk'] ?? null,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            'status_pegawai' => $validated['status_pegawai'] ?? null,
            'pendidikan_terakhir' => $validated['pendidikan_terakhir'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'email' => $validated['email'] ?? null,
            'no_hp' => $validated['no_hp'] ?? null,
            'foto_path' => $fotoPath,
        ]);

        $this->logActivity(
            'Pegawai',
            'Edit Data',
            'Memperbarui data pegawai: ' . $pegawai->nama_pegawai
        );

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diupdate');
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $namaPegawai = $pegawai->nama_pegawai;

        // hapus foto
        if ($pegawai->foto_path && Storage::disk('public')->exists($pegawai->foto_path)) {
            Storage::disk('public')->delete($pegawai->foto_path);
        }

        $pegawai->delete();

        $this->logActivity(
            'Pegawai',
            'Hapus Data',
            'Menghapus data pegawai: ' . $namaPegawai
        );

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil dihapus');
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:pegawai,id_pegawai'],
        ]);

        $pegawaiList = Pegawai::whereIn('id_pegawai', $validated['ids'])->get();

        foreach ($pegawaiList as $pegawai) {
            if ($pegawai->foto_path && Storage::disk('public')->exists($pegawai->foto_path)) {
                Storage::disk('public')->delete($pegawai->foto_path);
            }

            $pegawai->delete();
        }

        $this->logActivity(
            'Pegawai',
            'Hapus Data',
            'Menghapus ' . count($validated['ids']) . ' data pegawai sekaligus'
        );

        return redirect()->back()->with('success', count($validated['ids']) . ' data pegawai berhasil dihapus');
    }
}
