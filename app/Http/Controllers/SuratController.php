<?php

namespace App\Http\Controllers;

use App\Models\DokumenPenyuratan;
use App\Models\JenisSurat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SuratController extends Controller
{
    public function index(Request $request): View
    {
        $selectedJenis = strtolower((string) $request->query('jenis', ''));
        $selectedBulan = $request->filled('bulan') ? (int) $request->query('bulan') : null;
        $selectedTahun = $request->filled('tahun') ? (int) $request->query('tahun') : null;

        $surat = DokumenPenyuratan::with('jenis')
            ->when(in_array($selectedJenis, ['masuk', 'keluar'], true), function ($query) use ($selectedJenis) {
                $query->whereHas('jenis', function ($jenisQuery) use ($selectedJenis) {
                    $jenisQuery->whereRaw('LOWER(nama_jenis_surat) = ?', [$selectedJenis]);
                });
            })
            ->when($selectedBulan, function ($query) use ($selectedBulan) {
                $query->whereMonth('tanggal_dokumen', $selectedBulan);
            })
            ->when($selectedTahun, function ($query) use ($selectedTahun) {
                $query->whereYear('tanggal_dokumen', $selectedTahun);
            })
            ->orderByDesc('tanggal_dokumen')
            ->orderByDesc('id_dokumen_penyuratan')
            ->paginate(10)
            ->withQueryString();

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

        return view('admin.penyuratan.index', [
            'surat' => $surat,
            'months' => $months,
            'years' => $years,
            'selectedJenis' => $selectedJenis,
            'selectedBulan' => $selectedBulan,
            'selectedTahun' => $selectedTahun,
        ]);
    }

    public function create(): View
    {
        $jenis = JenisSurat::orderByRaw("
                CASE
                    WHEN LOWER(nama_jenis_surat) = 'masuk' THEN 1
                    WHEN LOWER(nama_jenis_surat) = 'keluar' THEN 2
                    ELSE 3
                END
            ")
            ->orderBy('nama_jenis_surat')
            ->get();

        return view('admin.penyuratan.create', [
            'jenis' => $jenis,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'no_surat' => [
                'required',
                'string',
                'max:60',
                Rule::unique('dokumen_penyuratan', 'no_surat'),
            ],
            'nama_dokumen' => ['required', 'string', 'max:150'],
            'tanggal_dokumen' => ['required', 'date'],
            'jenis_surat' => ['required', 'in:masuk,keluar'],
            'nama_pengirim_penerima' => ['required', 'string', 'max:120'],
            'file_surat' => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png', 'max:5120'],
        ]);
        $user = Auth::user();
        $jenisSurat = $this->resolveJenisSurat($validated['jenis_surat']);

        abort_unless($user, 403, 'User belum login');

        $path = $request->file('file_surat')->store('surat', 'public');

        DokumenPenyuratan::create([
            'id_user' => $user->id_user,
            'nama_dokumen' => $validated['nama_dokumen'],
            'no_surat' => $validated['no_surat'],
            'tanggal_dokumen' => $validated['tanggal_dokumen'],
            'id_jenis_surat' => $jenisSurat->id_jenis_surat,
            'nama_pengirim_penerima' => $validated['nama_pengirim_penerima'],
            'file_path' => $path,
            'created_by' => $user->username ?? 'System',
            'bulan' => Carbon::parse($validated['tanggal_dokumen'])->month,
            'tahun' => Carbon::parse($validated['tanggal_dokumen'])->year,
        ]);

        return redirect()
            ->route('penyuratan.index')
            ->with('success', 'Surat berhasil ditambahkan.');
    }

    public function show($id): View
    {
        $surat = DokumenPenyuratan::with('jenis')->findOrFail($id);
        $extension = strtolower(pathinfo($surat->file_path ?? '', PATHINFO_EXTENSION));
        $previewableExtensions = ['pdf', 'jpg', 'jpeg', 'png'];

        return view('admin.penyuratan.show', [
            'surat' => $surat,
            'isPreviewable' => in_array($extension, $previewableExtensions, true),
            'fileUrl' => $surat->file_path ? asset('storage/' . $surat->file_path) : null,
        ]);
    }

    public function edit($id): View
    {
        return view('admin.penyuratan.edit', [
            'surat' => DokumenPenyuratan::findOrFail($id),
            'jenis' => JenisSurat::orderBy('nama_jenis_surat')->get(),
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $surat = DokumenPenyuratan::findOrFail($id);
        $validated = $request->validate([
            'no_surat' => [
                'required',
                'string',
                'max:60',
                Rule::unique('dokumen_penyuratan', 'no_surat')->ignore($surat->id_dokumen_penyuratan, 'id_dokumen_penyuratan'),
            ],
            'nama_dokumen' => ['required', 'string', 'max:150'],
            'tanggal_dokumen' => ['required', 'date'],
            'jenis_surat' => ['required', 'in:masuk,keluar'],
            'nama_pengirim_penerima' => ['required', 'string', 'max:120'],
            'file_surat' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png', 'max:5120'],
        ]);
        $jenisSurat = $this->resolveJenisSurat($validated['jenis_surat']);

        $payload = [
            'nama_dokumen' => $validated['nama_dokumen'],
            'no_surat' => $validated['no_surat'],
            'tanggal_dokumen' => $validated['tanggal_dokumen'],
            'id_jenis_surat' => $jenisSurat->id_jenis_surat,
            'nama_pengirim_penerima' => $validated['nama_pengirim_penerima'],
            'bulan' => Carbon::parse($validated['tanggal_dokumen'])->month,
            'tahun' => Carbon::parse($validated['tanggal_dokumen'])->year,
        ];

        if ($request->hasFile('file_surat')) {
            if ($surat->file_path && Storage::disk('public')->exists($surat->file_path)) {
                Storage::disk('public')->delete($surat->file_path);
            }

            $payload['file_path'] = $request->file('file_surat')->store('surat', 'public');
        }

        $surat->update($payload);

        return redirect()
            ->route('penyuratan.index')
            ->with('success', 'Surat berhasil diperbarui.');
    }

    public function destroy($id): RedirectResponse
    {
        $surat = DokumenPenyuratan::findOrFail($id);

        $this->deleteStoredSurat($surat);
        $surat->delete();

        return redirect()
            ->route('penyuratan.index')
            ->with('success', 'Data surat berhasil dihapus.');
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:dokumen_penyuratan,id_dokumen_penyuratan'],
        ]);

        $documents = DokumenPenyuratan::whereIn('id_dokumen_penyuratan', $validated['ids'])->get();

        foreach ($documents as $document) {
            $this->deleteStoredSurat($document);
            $document->delete();
        }

        return redirect()
            ->back()
            ->with('success', count($validated['ids']) . ' data surat berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        $surat = DokumenPenyuratan::with('jenis')
            ->when($request->filled('jenis') && in_array(strtolower((string) $request->jenis), ['masuk', 'keluar'], true), function ($query) use ($request) {
                $jenis = strtolower((string) $request->jenis);

                $query->whereHas('jenis', function ($jenisQuery) use ($jenis) {
                    $jenisQuery->whereRaw('LOWER(nama_jenis_surat) = ?', [$jenis]);
                });
            })
            ->when($request->filled('bulan'), function ($query) use ($request) {
                $query->whereMonth('tanggal_dokumen', (int) $request->bulan);
            })
            ->when($request->filled('tahun'), function ($query) use ($request) {
                $query->whereYear('tanggal_dokumen', (int) $request->tahun);
            })
            ->orderByDesc('tanggal_dokumen')
            ->get();

        $pdf = Pdf::loadView('admin.penyuratan.pdf', compact('surat'));

        return $pdf->download('laporan-penyuratan.pdf');
    }

    private function resolveJenisSurat(string $jenis): JenisSurat
    {
        $jenisName = ucfirst(strtolower($jenis));

        return JenisSurat::firstOrCreate([
            'nama_jenis_surat' => $jenisName,
        ]);
    }

    private function deleteStoredSurat(DokumenPenyuratan $surat): void
    {
        if ($surat->file_path && Storage::disk('public')->exists($surat->file_path)) {
            Storage::disk('public')->delete($surat->file_path);
        }
    }

    private function rules(?int $id = null, bool $requireFile = true): array
    {
        $fileRules = ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png', 'max:5120'];

        if ($requireFile) {
            $fileRules[0] = 'required';
        }

        return [
            'no_surat' => [
                'required',
                'string',
                'max:60',
                Rule::unique('dokumen_penyuratan', 'no_surat')->ignore($id, 'id_dokumen_penyuratan'),
            ],
            'nama_dokumen' => ['required', 'string', 'max:150'],
            'tanggal_dokumen' => ['required', 'date'],
            'id_jenis_surat' => ['required', 'exists:jenis_surat,id_jenis_surat'],
            'nama_pengirim_penerima' => ['required', 'string', 'max:120'],
            'file_surat' => $fileRules,
        ];
    }
}
