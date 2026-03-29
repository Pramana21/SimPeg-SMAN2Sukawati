<?php

namespace App\Http\Controllers;

use App\Models\DokumenInventaris;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class InventarisController extends Controller
{
    public function index(Request $request): View
    {
        $selectedBulan = $request->filled('bulan') ? (int) $request->query('bulan') : null;
        $selectedTahun = $request->filled('tahun') ? (int) $request->query('tahun') : null;

        $data = DokumenInventaris::query()
            ->when($selectedBulan, function ($query) use ($selectedBulan) {
                $query->whereMonth('tanggal_dokumen', $selectedBulan);
            })
            ->when($selectedTahun, function ($query) use ($selectedTahun) {
                $query->whereYear('tanggal_dokumen', $selectedTahun);
            })
            ->orderByDesc('tanggal_dokumen')
            ->orderByDesc('id_dokumen_inventaris')
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

        return view('admin.inventaris.index', [
            'data' => $data,
            'months' => $months,
            'years' => $years,
            'selectedBulan' => $selectedBulan,
            'selectedTahun' => $selectedTahun,
        ]);
    }

    public function create(): View
    {
        return view('admin.inventaris.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $user = Auth::user();

        abort_unless($user, 403, 'User belum login');

        $path = $request->file('file_surat')->store('inventaris', 'public');

        DokumenInventaris::create([
            'id_user' => $user->id_user,
            'nama_dokumen' => $validated['nama_dokumen'],
            'tanggal_dokumen' => $validated['tanggal_dokumen'],
            'file_path' => $path,
            'created_by' => $validated['created_by'] ?: ($user->username ?? 'Admin'),
            'bulan' => Carbon::parse($validated['tanggal_dokumen'])->month,
            'tahun' => Carbon::parse($validated['tanggal_dokumen'])->year,
        ]);

        return redirect()
            ->route('inventaris.index')
            ->with('success', 'Dokumen inventaris berhasil ditambahkan.');
    }

    public function show($id): View
    {
        $inventaris = DokumenInventaris::findOrFail($id);
        $extension = strtolower(pathinfo($inventaris->file_path ?? '', PATHINFO_EXTENSION));
        $previewableExtensions = ['pdf', 'jpg', 'jpeg', 'png'];

        return view('admin.inventaris.show', [
            'inventaris' => $inventaris,
            'isPreviewable' => in_array($extension, $previewableExtensions, true),
            'fileUrl' => $inventaris->file_path ? asset('storage/' . $inventaris->file_path) : null,
        ]);
    }

    public function edit($id): View
    {
        return view('admin.inventaris.edit', [
            'inventaris' => DokumenInventaris::findOrFail($id),
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $inventaris = DokumenInventaris::findOrFail($id);
        $validated = $request->validate($this->rules(false));

        $payload = [
            'nama_dokumen' => $validated['nama_dokumen'],
            'tanggal_dokumen' => $validated['tanggal_dokumen'],
            'created_by' => $validated['created_by'] ?: ($inventaris->created_by ?: (Auth::user()->username ?? 'Admin')),
            'bulan' => Carbon::parse($validated['tanggal_dokumen'])->month,
            'tahun' => Carbon::parse($validated['tanggal_dokumen'])->year,
        ];

        if ($request->hasFile('file_surat')) {
            if ($inventaris->file_path && Storage::disk('public')->exists($inventaris->file_path)) {
                Storage::disk('public')->delete($inventaris->file_path);
            }

            $payload['file_path'] = $request->file('file_surat')->store('inventaris', 'public');
        }

        $inventaris->update($payload);

        return redirect()
            ->route('inventaris.index')
            ->with('success', 'Dokumen inventaris berhasil diperbarui.');
    }

    public function destroy($id): RedirectResponse
    {
        $inventaris = DokumenInventaris::findOrFail($id);

        $this->deleteStoredInventaris($inventaris);
        $inventaris->delete();

        return redirect()
            ->route('inventaris.index')
            ->with('success', 'Dokumen inventaris berhasil dihapus.');
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:dokumen_inventaris,id_dokumen_inventaris'],
        ]);

        $documents = DokumenInventaris::whereIn('id_dokumen_inventaris', $validated['ids'])->get();

        foreach ($documents as $document) {
            $this->deleteStoredInventaris($document);
            $document->delete();
        }

        return redirect()
            ->back()
            ->with('success', count($validated['ids']) . ' dokumen inventaris berhasil dihapus.');
    }

    private function rules(bool $requireFile = true): array
    {
        $fileRules = ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png', 'max:5120'];

        if ($requireFile) {
            $fileRules[0] = 'required';
        }

        return [
            'nama_dokumen' => ['required', 'string', 'max:150'],
            'tanggal_dokumen' => ['required', 'date'],
            'created_by' => ['nullable', 'string', 'max:100'],
            'file_surat' => $fileRules,
        ];
    }

    private function deleteStoredInventaris(DokumenInventaris $inventaris): void
    {
        if ($inventaris->file_path && Storage::disk('public')->exists($inventaris->file_path)) {
            Storage::disk('public')->delete($inventaris->file_path);
        }
    }
}
