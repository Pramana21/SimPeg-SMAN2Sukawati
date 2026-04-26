<?php

namespace App\Http\Controllers;

use App\Models\DokumenKeuangan;
use App\Models\KategoriKeuangan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class KeuanganController extends Controller
{
    public function index(Request $request): View
    {
        $selectedBulan = $request->filled('bulan') ? (int) $request->query('bulan') : null;
        $selectedTahun = $request->filled('tahun') ? (int) $request->query('tahun') : null;

        $data = DokumenKeuangan::with('kategori')
            ->when($selectedBulan, function ($query) use ($selectedBulan) {
                $query->whereMonth('tanggal_dokumen', $selectedBulan);
            })
            ->when($selectedTahun, function ($query) use ($selectedTahun) {
                $query->whereYear('tanggal_dokumen', $selectedTahun);
            })
            ->orderByDesc('tanggal_dokumen')
            ->orderByDesc('id_dokumen_keuangan')
            ->paginate(10)
            ->withQueryString();

        return view('admin.keuangan.index', [
            'data' => $data,
            'title' => 'Overview Keuangan',
            ...$this->buildFilterOptions($selectedBulan, $selectedTahun),
        ]);
    }

    public function show(Request $request, string $slug): View
    {
        $kategori = KategoriKeuangan::where('slug', $slug)->firstOrFail();
        $selectedBulan = $request->filled('bulan') ? (int) $request->query('bulan') : null;
        $selectedTahun = $request->filled('tahun') ? (int) $request->query('tahun') : null;

        $data = DokumenKeuangan::with('kategori')
            ->where('id_kategori_keuangan', $kategori->id_kategori_keuangan)
            ->when($selectedBulan, function ($query) use ($selectedBulan) {
                $query->whereMonth('tanggal_dokumen', $selectedBulan);
            })
            ->when($selectedTahun, function ($query) use ($selectedTahun) {
                $query->whereYear('tanggal_dokumen', $selectedTahun);
            })
            ->orderByDesc('tanggal_dokumen')
            ->orderByDesc('id_dokumen_keuangan')
            ->paginate(10)
            ->withQueryString();

        return view('admin.keuangan.kategori', [
            'data' => $data,
            'kategori' => $kategori,
            'title' => $kategori->nama_kategori,
            ...$this->buildFilterOptions($selectedBulan, $selectedTahun),
        ]);
    }

    public function create(string $slug): View
    {
        $kategori = KategoriKeuangan::where('slug', $slug)->firstOrFail();

        return view('admin.keuangan.create', [
            'kategori' => $kategori,
            'slug' => $slug,
        ]);
    }

    public function store(Request $request, string $slug): RedirectResponse
    {
        $kategori = KategoriKeuangan::where('slug', $slug)->firstOrFail();
        $validated = $request->validate($this->rules());
        $user = Auth::user();

        abort_unless($user, 403, 'User belum login');

        $path = $request->file('file')->store('keuangan', 'public');

        $dokumen = DokumenKeuangan::create([
            'id_user' => $user->id_user ?? $user->id ?? null,
            'nama_dokumen' => $validated['nama_dokumen'],
            'tanggal_dokumen' => $validated['tanggal_dokumen'],
            'id_kategori_keuangan' => $kategori->id_kategori_keuangan,
            'file_path' => $path,
            'created_by' => $validated['created_by'] ?: ($user->username ?? 'Admin'),
            'bulan' => Carbon::parse($validated['tanggal_dokumen'])->month,
            'tahun' => Carbon::parse($validated['tanggal_dokumen'])->year,
        ]);

        $this->logActivity(
            'Keuangan',
            'Tambah Data',
            'Menambahkan dokumen keuangan: ' . $dokumen->nama_dokumen
        );

        return redirect()
            ->route('keuangan.kategori', $slug)
            ->with('success', 'Dokumen keuangan berhasil ditambahkan.');
    }

    public function preview(string $slug, int $id): View
    {
        $kategori = KategoriKeuangan::where('slug', $slug)->firstOrFail();
        $data = DokumenKeuangan::with('kategori')
            ->where('id_kategori_keuangan', $kategori->id_kategori_keuangan)
            ->findOrFail($id);
        $extension = strtolower(pathinfo($data->file_path ?? '', PATHINFO_EXTENSION));
        $previewableExtensions = ['pdf', 'jpg', 'jpeg', 'png'];

        return view('admin.keuangan.show', [
            'data' => $data,
            'kategori' => $kategori,
            'fileUrl' => $data->file_path ? asset('storage/' . $data->file_path) : null,
            'isPreviewable' => in_array($extension, $previewableExtensions, true),
        ]);
    }

    public function edit(string $slug, int $id): View
    {
        $kategori = KategoriKeuangan::where('slug', $slug)->firstOrFail();
        $data = DokumenKeuangan::with('kategori')
            ->where('id_kategori_keuangan', $kategori->id_kategori_keuangan)
            ->findOrFail($id);

        return view('admin.keuangan.edit', [
            'data' => $data,
            'kategori' => $kategori,
            'slug' => $slug,
        ]);
    }

    public function update(Request $request, string $slug, int $id): RedirectResponse
    {
        $kategori = KategoriKeuangan::where('slug', $slug)->firstOrFail();
        $data = DokumenKeuangan::where('id_kategori_keuangan', $kategori->id_kategori_keuangan)
            ->findOrFail($id);
        $validated = $request->validate($this->rules(false));
        $user = Auth::user();

        $payload = [
            'nama_dokumen' => $validated['nama_dokumen'],
            'tanggal_dokumen' => $validated['tanggal_dokumen'],
            'created_by' => $validated['created_by'] ?: ($data->created_by ?: ($user->username ?? 'Admin')),
            'bulan' => Carbon::parse($validated['tanggal_dokumen'])->month,
            'tahun' => Carbon::parse($validated['tanggal_dokumen'])->year,
        ];

        if ($request->hasFile('file')) {
            if ($data->file_path && Storage::disk('public')->exists($data->file_path)) {
                Storage::disk('public')->delete($data->file_path);
            }

            $payload['file_path'] = $request->file('file')->store('keuangan', 'public');
        }

        $data->update($payload);

        $this->logActivity(
            'Keuangan',
            'Edit Data',
            'Memperbarui dokumen keuangan: ' . $data->nama_dokumen
        );

        return redirect()
            ->route('keuangan.kategori', $slug)
            ->with('success', 'Dokumen keuangan berhasil diperbarui.');
    }

    public function destroy(string $slug, int $id): RedirectResponse
    {
        $kategori = KategoriKeuangan::where('slug', $slug)->firstOrFail();
        $data = DokumenKeuangan::where('id_kategori_keuangan', $kategori->id_kategori_keuangan)
            ->findOrFail($id);
        $namaDokumen = $data->nama_dokumen;

        $this->deleteStoredFile($data);
        $data->delete();

        $this->logActivity(
            'Keuangan',
            'Hapus Data',
            'Menghapus dokumen keuangan: ' . $namaDokumen
        );

        return redirect()
            ->back()
            ->with('success', 'Dokumen keuangan berhasil dihapus.');
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:dokumen_keuangan,id_dokumen_keuangan'],
        ]);

        $documents = DokumenKeuangan::whereIn('id_dokumen_keuangan', $validated['ids'])->get();

        foreach ($documents as $document) {
            $this->deleteStoredFile($document);
            $document->delete();
        }

        $this->logActivity(
            'Keuangan',
            'Hapus Data',
            'Menghapus ' . count($validated['ids']) . ' dokumen keuangan sekaligus'
        );

        return redirect()
            ->back()
            ->with('success', count($validated['ids']) . ' dokumen keuangan berhasil dihapus.');
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

    private function rules(bool $requireFile = true): array
    {
        $fileRules = ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png', 'max:2048'];

        if ($requireFile) {
            $fileRules[0] = 'required';
        }

        return [
            'nama_dokumen' => ['required', 'string', 'max:255'],
            'tanggal_dokumen' => ['required', 'date'],
            'created_by' => ['required', 'string', 'max:255'],
            'file' => $fileRules,
        ];
    }

    private function deleteStoredFile(DokumenKeuangan $data): void
    {
        if ($data->file_path && Storage::disk('public')->exists($data->file_path)) {
            Storage::disk('public')->delete($data->file_path);
        }
    }
}
