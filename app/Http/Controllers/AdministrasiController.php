<?php

namespace App\Http\Controllers;

use App\Models\DokumenAdministrasi;
use App\Models\JenisDokumenAdministrasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdministrasiController extends Controller
{
    private function buildKategoriKelas(?string $kelas, ?string $nomorKelas): ?string
    {
        if (!$kelas || !$nomorKelas) {
            return null;
        }

        $prefix = $kelas === 'X' ? 'E' : 'F';

        return $prefix . ' - ' . $nomorKelas;
    }

    public function index(Request $request): View
    {
        $selectedKategori = $request->query('kategori');
        $selectedBulan = $request->filled('bulan') ? (int) $request->query('bulan') : null;
        $selectedTahun = $request->filled('tahun') ? (int) $request->query('tahun') : null;

        $data = $this->queryAdministrasi($selectedBulan, $selectedTahun, null, $selectedKategori);

        return view('admin.administrasi.index', [
            'title' => 'Dashboard Administrasi Umum',
            'data' => $data,
            'selectedKategoriFilter' => $selectedKategori,
            'kategoriOptions' => $this->dashboardKategoriOptions(),
            ...$this->buildFilterOptions($selectedBulan, $selectedTahun),
        ]);
    }

    public function pegawai(Request $request): View
    {
        return $this->renderSubmodulePage($request, 'Pegawai');
    }

    public function siswa(Request $request): View
    {
        return $this->renderSubmodulePage($request, 'Siswa');
    }

    public function createPegawai(): View
    {
        return view('admin.administrasi.create-pegawai', [
            'jenisDokumenOptions' => [
                ['value' => 'absensi_pegawai', 'label' => 'Absensi Pegawai'],
                ['value' => 'laporan_piket', 'label' => 'Laporan Piket'],
            ],
            'backRoute' => 'administrasi.pegawai.index',
            'selectedKategori' => 'Pegawai',
        ]);
    }

    public function createSiswa(): View
    {
        return view('admin.administrasi.create-siswa', [
            'jenisDokumenOptions' => [
                ['value' => 'absensi_siswa', 'label' => 'Absensi Siswa'],
                ['value' => 'jurnal_kelas', 'label' => 'Jurnal Kelas'],
            ],
            'backRoute' => 'administrasi.siswa.index',
            'selectedKategori' => 'Siswa',
            'showClassFields' => true,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_dokumen' => 'required|string|max:150',
            'tanggal_dokumen' => 'required|date',
            'jenis_dokumen' => 'required|string',
            'di_upload_oleh' => 'required|string|max:255',
            'selected_kategori' => 'nullable|in:Pegawai,Siswa',
            'file_surat' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,png|max:2048',
            'kelas' => 'nullable|in:X,XI,XII',
            'nomor_kelas' => 'nullable|integer|min:1|max:10',
        ]);

        if (($validated['selected_kategori'] ?? null) === 'Siswa') {
            $request->validate([
                'kelas' => 'required|in:X,XI,XII',
                'nomor_kelas' => 'required|integer|min:1|max:10',
            ]);
        }

        $jenis = $this->resolveJenisDokumen($validated['jenis_dokumen']);
        $path = $request->file('file_surat')->store('administrasi', 'public');
        $kategoriKelas = ($validated['selected_kategori'] ?? null) === 'Siswa'
            ? $this->buildKategoriKelas($request->kelas, $request->nomor_kelas)
            : null;

        $dokumen = DokumenAdministrasi::create([
            'id_user' => Auth::id(),
            'nama_dokumen' => $validated['nama_dokumen'],
            'tanggal_dokumen' => $validated['tanggal_dokumen'],
            'id_jenis_dokumen_administrasi' => $jenis->id_jenis_dokumen_administrasi,
            'file_path' => $path,
            'created_by' => $validated['di_upload_oleh'],
            'kelas' => ($validated['selected_kategori'] ?? null) === 'Siswa' ? $request->kelas : null,
            'kategori_kelas' => $kategoriKelas,
            'bulan' => date('m', strtotime($validated['tanggal_dokumen'])),
            'tahun' => date('Y', strtotime($validated['tanggal_dokumen'])),
        ]);

        $this->logActivity(
            'Administrasi',
            'Tambah Data',
            'Menambahkan dokumen administrasi: ' . $dokumen->nama_dokumen
        );

        return redirect()
            ->route($this->submoduleRouteName($validated['selected_kategori'] ?? ($jenis->kategori->nama_kategori ?? 'Pegawai')))
            ->with('success', 'Dokumen administrasi berhasil ditambahkan.');
    }

    public function show($id): View
    {
        $data = DokumenAdministrasi::with('jenis.kategori')->findOrFail($id);
        $extension = strtolower(pathinfo($data->file_path ?? '', PATHINFO_EXTENSION));
        $previewableExtensions = ['pdf', 'jpg', 'jpeg', 'png'];

        return view('admin.administrasi.show', [
            'data' => $data,
            'isPreviewable' => in_array($extension, $previewableExtensions, true),
            'fileUrl' => $data->file_path ? asset('storage/' . $data->file_path) : null,
            'backRoute' => $this->submoduleRouteName($data->jenis->kategori->nama_kategori ?? 'Pegawai'),
        ]);
    }

    public function edit($id): View
    {
        $data = DokumenAdministrasi::with('jenis.kategori')->findOrFail($id);
        $selectedKategori = $data->jenis->kategori->nama_kategori ?? 'Pegawai';

        return view('admin.administrasi.edit', [
            'data' => $data,
            'selectedKategori' => $selectedKategori,
            'backRoute' => $this->submoduleRouteName($selectedKategori),
            'storeRoute' => 'administrasi.update',
            'showClassFields' => $selectedKategori === 'Siswa',
            'jenisDokumenOptions' => $selectedKategori === 'Siswa'
                ? [
                    ['value' => 'absensi_siswa', 'label' => 'Absensi Siswa'],
                    ['value' => 'jurnal_kelas', 'label' => 'Jurnal Kelas'],
                ]
                : [
                    ['value' => 'absensi_pegawai', 'label' => 'Absensi Pegawai'],
                    ['value' => 'laporan_piket', 'label' => 'Laporan Piket'],
                ],
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $data = DokumenAdministrasi::findOrFail($id);
        $validated = $request->validate([
            'nama_dokumen' => 'required|string|max:150',
            'tanggal_dokumen' => 'required|date',
            'jenis_dokumen' => 'required|string',
            'di_upload_oleh' => 'required|string|max:255',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,png|max:2048',
        ]);

        $jenis = $this->resolveJenisDokumen($validated['jenis_dokumen']);

        if ($request->hasFile('file_surat')) {
            if ($data->file_path && Storage::disk('public')->exists($data->file_path)) {
                Storage::disk('public')->delete($data->file_path);
            }

            $data->file_path = $request->file('file_surat')->store('administrasi', 'public');
        }

        $data->nama_dokumen = $validated['nama_dokumen'];
        $data->tanggal_dokumen = $validated['tanggal_dokumen'];
        $data->id_jenis_dokumen_administrasi = $jenis->id_jenis_dokumen_administrasi;
        $data->created_by = $validated['di_upload_oleh'];
        $data->bulan = date('m', strtotime($validated['tanggal_dokumen']));
        $data->tahun = date('Y', strtotime($validated['tanggal_dokumen']));
        $data->save();

        $this->logActivity(
            'Administrasi',
            'Edit Data',
            'Memperbarui dokumen administrasi: ' . $data->nama_dokumen
        );

        return redirect()
            ->route($this->submoduleRouteName($jenis->kategori->nama_kategori ?? 'Pegawai'))
            ->with('success', 'Dokumen administrasi berhasil diperbarui.');
    }

    public function destroy($id): RedirectResponse
    {
        $data = DokumenAdministrasi::findOrFail($id);
        $namaDokumen = $data->nama_dokumen;

        if ($data->file_path && Storage::disk('public')->exists($data->file_path)) {
            Storage::disk('public')->delete($data->file_path);
        }

        $data->delete();

        $this->logActivity(
            'Administrasi',
            'Hapus Data',
            'Menghapus dokumen administrasi: ' . $namaDokumen
        );

        return redirect()->back()->with('success', 'Dokumen administrasi berhasil dihapus.');
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:dokumen_administrasi,id_dokumen_administrasi'],
        ]);

        $documents = DokumenAdministrasi::whereIn('id_dokumen_administrasi', $validated['ids'])->get();

        foreach ($documents as $document) {
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $document->delete();
        }

        $this->logActivity(
            'Administrasi',
            'Hapus Data',
            'Menghapus ' . count($validated['ids']) . ' dokumen administrasi sekaligus'
        );

        return redirect()->back()->with('success', count($validated['ids']) . ' dokumen administrasi berhasil dihapus.');
    }

    private function renderSubmodulePage(Request $request, string $kategori): View
    {
        $selectedBulan = $request->filled('bulan') ? (int) $request->query('bulan') : null;
        $selectedTahun = $request->filled('tahun') ? (int) $request->query('tahun') : null;
        $data = $this->queryAdministrasi($selectedBulan, $selectedTahun, $kategori);

        return view($kategori === 'Pegawai' ? 'admin.administrasi.pegawai' : 'admin.administrasi.siswa', [
            'data' => $data,
            'title' => $kategori,
            'selectedKategori' => $kategori,
            'createRoute' => $kategori === 'Pegawai' ? 'administrasi.pegawai.create' : 'administrasi.siswa.create',
            ...$this->buildFilterOptions($selectedBulan, $selectedTahun),
        ]);
    }

    private function queryAdministrasi(?int $selectedBulan, ?int $selectedTahun, ?string $kategoriModul = null, ?string $kategoriFilter = null)
    {
        return DokumenAdministrasi::with('jenis.kategori')
            ->when(in_array($kategoriModul, ['Pegawai', 'Siswa'], true), function ($query) use ($kategoriModul) {
                $query->whereHas('jenis.kategori', function ($kategoriQuery) use ($kategoriModul) {
                    $kategoriQuery->where('nama_kategori', $kategoriModul);
                });
            })
            ->when($kategoriFilter, function ($query) use ($kategoriFilter) {
                $mapped = $this->mapKategoriFilterToDisplay($kategoriFilter);

                if ($mapped) {
                    $query->whereHas('jenis', function ($jenisQuery) use ($mapped) {
                        $jenisQuery->where('nama_jenis', $mapped);
                    });
                }
            })
            ->when($selectedBulan, function ($query) use ($selectedBulan) {
                $query->whereMonth('tanggal_dokumen', $selectedBulan);
            })
            ->when($selectedTahun, function ($query) use ($selectedTahun) {
                $query->whereYear('tanggal_dokumen', $selectedTahun);
            })
            ->orderByDesc('tanggal_dokumen')
            ->orderByDesc('id_dokumen_administrasi')
            ->paginate(10)
            ->withQueryString();
    }

    private function resolveJenisDokumen(string $jenisDokumen): JenisDokumenAdministrasi
    {
        $displayName = $this->mapJenisDokumenValueToDisplay($jenisDokumen);

        return JenisDokumenAdministrasi::with('kategori')
            ->where('nama_jenis', $displayName)
            ->firstOrFail();
    }

    private function mapJenisDokumenValueToDisplay(string $value): string
    {
        return [
            'absensi_pegawai' => 'Absensi Pegawai',
            'laporan_piket' => 'Laporan Piket',
            'absensi_siswa' => 'Absensi Siswa',
            'jurnal_kelas' => 'Jurnal Kelas',
        ][$value] ?? $value;
    }

    private function mapKategoriFilterToDisplay(?string $value): ?string
    {
        if (!$value) {
            return null;
        }

        return $this->mapJenisDokumenValueToDisplay($value);
    }

    private function dashboardKategoriOptions(): array
    {
        return [
            ['value' => 'absensi_pegawai', 'label' => 'Absensi Pegawai'],
            ['value' => 'laporan_piket', 'label' => 'Laporan Piket'],
            ['value' => 'absensi_siswa', 'label' => 'Absensi Siswa'],
            ['value' => 'jurnal_kelas', 'label' => 'Jurnal Kelas'],
        ];
    }

    private function buildFilterOptions(?int $selectedBulan, ?int $selectedTahun): array
    {
        $months = collect([
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ]);

        $currentYear = (int) now()->year;
        $years = range($currentYear, $currentYear + 9);

        return [
            'months' => $months,
            'years' => $years,
            'selectedBulan' => $selectedBulan,
            'selectedTahun' => $selectedTahun,
        ];
    }

    private function submoduleRouteName(string $kategori): string
    {
        return $kategori === 'Siswa'
            ? 'administrasi.siswa.index'
            : 'administrasi.pegawai.index';
    }
}
