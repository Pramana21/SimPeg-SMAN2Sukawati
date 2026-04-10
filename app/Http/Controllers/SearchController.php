<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request): RedirectResponse
    {
        abort_unless(
            auth()->user()?->hasRole('Super Admin') || auth()->user()?->hasRole('Admin Kepegawaian'),
            403,
            'Tidak memiliki akses'
        );

        $keyword = trim((string) $request->input('q', ''));

        if ($keyword === '') {
            return back()->with('error', 'Masukkan kata kunci pencarian.');
        }

        $like = '%' . $keyword . '%';

        $penyuratan = DB::table('dokumen_penyuratan')
            ->where(function ($query) use ($like) {
                $query->where('no_surat', 'like', $like)
                    ->orWhere('nama_dokumen', 'like', $like);
            })
            ->selectRaw("
                no_surat as kode,
                nama_dokumen as nama,
                id_dokumen_penyuratan as id,
                'penyuratan' as sumber,
                null as slug,
                created_at
            ");

        $keuangan = DB::table('dokumen_keuangan')
            ->leftJoin('kategori_keuangan', 'kategori_keuangan.id_kategori_keuangan', '=', 'dokumen_keuangan.id_kategori_keuangan')
            ->where(function ($query) use ($like) {
                $query->whereRaw('CAST(dokumen_keuangan.id_dokumen_keuangan as char) like ?', [$like])
                    ->orWhere('dokumen_keuangan.nama_dokumen', 'like', $like);
            })
            ->selectRaw("
                CAST(dokumen_keuangan.id_dokumen_keuangan as char) as kode,
                dokumen_keuangan.nama_dokumen as nama,
                dokumen_keuangan.id_dokumen_keuangan as id,
                'keuangan' as sumber,
                kategori_keuangan.slug as slug,
                dokumen_keuangan.created_at
            ");

        $inventaris = DB::table('dokumen_inventaris')
            ->where(function ($query) use ($like) {
                $query->whereRaw('CAST(id_dokumen_inventaris as char) like ?', [$like])
                    ->orWhere('nama_dokumen', 'like', $like);
            })
            ->selectRaw("
                CAST(id_dokumen_inventaris as char) as kode,
                nama_dokumen as nama,
                id_dokumen_inventaris as id,
                'inventaris' as sumber,
                null as slug,
                created_at
            ");

        $administrasi = DB::table('dokumen_administrasi')
            ->where(function ($query) use ($like) {
                $query->whereRaw('CAST(id_dokumen_administrasi as char) like ?', [$like])
                    ->orWhere('nama_dokumen', 'like', $like);
            })
            ->selectRaw("
                CAST(id_dokumen_administrasi as char) as kode,
                nama_dokumen as nama,
                id_dokumen_administrasi as id,
                'administrasi' as sumber,
                null as slug,
                created_at
            ");

        $siswa = DB::table('siswa')
            ->where(function ($query) use ($like) {
                $query->where('nis', 'like', $like)
                    ->orWhere('nama_siswa', 'like', $like);
            })
            ->selectRaw("
                nis as kode,
                nama_siswa as nama,
                id_siswa as id,
                'siswa' as sumber,
                null as slug,
                created_at
            ");

        $pegawai = DB::table('pegawai')
            ->where(function ($query) use ($like) {
                $query->where('nip_nippk', 'like', $like)
                    ->orWhere('nama_pegawai', 'like', $like);
            })
            ->selectRaw("
                nip_nippk as kode,
                nama_pegawai as nama,
                id_pegawai as id,
                'pegawai' as sumber,
                null as slug,
                created_at
            ");

        $results = $penyuratan
            ->unionAll($keuangan)
            ->unionAll($inventaris)
            ->unionAll($administrasi)
            ->unionAll($siswa)
            ->unionAll($pegawai);

        $result = DB::query()
            ->fromSub($results, 'search_results')
            ->orderByDesc('created_at')
            ->limit(1)
            ->first();

        if (!$result) {
            return back()->with('error', 'Dokumen tidak ditemukan');
        }

        return match ($result->sumber) {
            'penyuratan' => redirect()->route('penyuratan.show', $result->id),
            'keuangan' => $result->slug
                ? redirect()->route('keuangan.preview', [$result->slug, $result->id])
                : redirect()->route('keuangan.index'),
            'inventaris' => redirect()->route('inventaris.show', $result->id),
            'administrasi' => redirect()->route('administrasi.show', $result->id),
            'siswa' => redirect()->route('murid.show', $result->id),
            'pegawai' => redirect()->route('pegawai.show', $result->id),
            default => back()->with('error', 'Dokumen tidak ditemukan'),
        };
    }
}
