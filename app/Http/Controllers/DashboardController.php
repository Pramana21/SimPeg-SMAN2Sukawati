<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\DokumenAdministrasi;
use App\Models\DokumenInventaris;
use App\Models\DokumenKeuangan;
use App\Models\DokumenPenyuratan;
use App\Models\Pegawai;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $user = auth()->user();

        abort_if(!$user, 403, 'Tidak memiliki akses');

        if ($user->hasRole('Admin Kepegawaian')) {
            return redirect()->route('dashboard.admin');
        }

        if ($user->hasRole('Tamu')) {
            return redirect()->route('dashboard.tamu');
        }

        if ($user->hasRole('Siswa')) {
            return redirect()->route('dashboard.siswa');
        }

        return $this->superAdmin();
    }

    public function superAdmin(): View
    {
        abort_if(
            auth()->user()?->hasRole('Admin Kepegawaian')
            || auth()->user()?->hasRole('Tamu')
            || auth()->user()?->hasRole('Siswa'),
            403,
            'Tidak memiliki akses'
        );

        $totalUser = User::count();
        $totalDokumen = $this->totalDocuments();
        $totalStaff = User::count();
        $totalSiswa = Siswa::count();
        $logs = $this->recentAuditLogs();

        return view('admin.dashboard.index', compact(
            'totalUser',
            'totalDokumen',
            'totalStaff',
            'totalSiswa',
            'logs'
        ));
    }

    public function admin(): View
    {
        abort_unless(auth()->user()?->hasRole('Admin Kepegawaian'), 403, 'Tidak memiliki akses');

        return view('dashboard.admin', $this->buildRoleDashboardPayload(
            title: 'Dashboard Admin Kepegawaian',
            subtitle: 'Ringkasan dokumen dan aktivitas utama untuk pengelolaan kepegawaian.',
            stats: [
                [
                    'label' => 'Surat Masuk',
                    'value' => $this->countPenyuratanByJenis('masuk'),
                    'icon' => 'mail-in',
                ],
                [
                    'label' => 'Surat Keluar',
                    'value' => $this->countPenyuratanByJenis('keluar'),
                    'icon' => 'mail-out',
                ],
                [
                    'label' => 'Total Staff',
                    'value' => Pegawai::count(),
                    'icon' => 'users',
                ],
                [
                    'label' => 'Total Murid',
                    'value' => Siswa::count(),
                    'icon' => 'students',
                ],
            ],
            roleBadge: 'Admin',
            recentDocuments: $this->recentDocuments(['penyuratan', 'keuangan', 'inventaris', 'administrasi']),
            agendaItems: $this->agendaFromDocuments(['penyuratan', 'keuangan', 'inventaris', 'administrasi']),
            sectionTitle: 'Dokumen Terbaru'
        ));
    }

    public function tamu(): View
    {
        abort_unless(auth()->user()?->hasRole('Tamu'), 403, 'Tidak memiliki akses');

        return view('dashboard.tamu', $this->buildRoleDashboardPayload(
            title: 'Dashboard Tamu',
            subtitle: 'Tampilan read-only untuk memantau data penting tanpa akses perubahan.',
            stats: [
                [
                    'label' => 'Total Dokumen',
                    'value' => $this->totalDocuments(),
                    'icon' => 'document',
                ],
                [
                    'label' => 'Penyuratan',
                    'value' => DokumenPenyuratan::count(),
                    'icon' => 'mail-in',
                ],
                [
                    'label' => 'Keuangan',
                    'value' => DokumenKeuangan::count(),
                    'icon' => 'wallet',
                ],
                [
                    'label' => 'Inventaris',
                    'value' => DokumenInventaris::count(),
                    'icon' => 'archive',
                ],
            ],
            roleBadge: 'Read Only',
            recentDocuments: $this->recentDocuments(['penyuratan', 'keuangan', 'inventaris', 'administrasi']),
            agendaItems: $this->agendaFromDocuments(['penyuratan', 'keuangan', 'inventaris']),
            sectionTitle: 'Dokumen yang Bisa Dipantau'
        ));
    }

    public function siswa(): View
    {
        abort_unless(auth()->user()?->hasRole('Siswa'), 403, 'Tidak memiliki akses');

        return view('dashboard.siswa', $this->buildRoleDashboardPayload(
            title: 'Dashboard Siswa',
            subtitle: 'Akses terbatas untuk melihat informasi umum dan dokumen administrasi yang relevan.',
            stats: [
                [
                    'label' => 'Dokumen Administrasi',
                    'value' => DokumenAdministrasi::count(),
                    'icon' => 'document',
                ],
                [
                    'label' => 'Total Murid',
                    'value' => Siswa::count(),
                    'icon' => 'students',
                ],
                [
                    'label' => 'Murid Aktif',
                    'value' => Siswa::where('is_active', true)->count(),
                    'icon' => 'badge',
                ],
                [
                    'label' => 'Akses Saya',
                    'value' => 'Terbatas',
                    'icon' => 'shield',
                ],
            ],
            roleBadge: 'Siswa',
            recentDocuments: $this->recentDocuments(['administrasi']),
            agendaItems: $this->agendaFromDocuments(['administrasi']),
            sectionTitle: 'Dokumen Administrasi Terbaru'
        ));
    }

    private function buildRoleDashboardPayload(
        string $title,
        string $subtitle,
        array $stats,
        string $roleBadge,
        Collection $recentDocuments,
        Collection $agendaItems,
        string $sectionTitle
    ): array {
        return [
            'dashboardTitle' => $title,
            'dashboardSubtitle' => $subtitle,
            'stats' => $stats,
            'roleBadge' => $roleBadge,
            'calendar' => $this->buildCalendar(now()),
            'studentComposition' => $this->studentComposition(),
            'recentDocuments' => $recentDocuments,
            'agendaItems' => $agendaItems,
            'sectionTitle' => $sectionTitle,
        ];
    }

    private function totalDocuments(): int
    {
        return DokumenAdministrasi::count()
            + DokumenKeuangan::count()
            + DokumenPenyuratan::count()
            + DokumenInventaris::count();
    }

    private function recentAuditLogs(): Collection
    {
        try {
            return AuditLog::with('user')
                ->latest('created_at')
                ->take(5)
                ->get();
        } catch (\Throwable $exception) {
            return collect();
        }
    }

    private function countPenyuratanByJenis(string $jenis): int
    {
        return DokumenPenyuratan::whereHas('jenis', function ($query) use ($jenis) {
            $query->whereRaw('LOWER(nama_jenis_surat) = ?', [strtolower($jenis)]);
        })->count();
    }

    private function buildCalendar(Carbon $date): array
    {
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();
        $startOfGrid = $startOfMonth->copy()->startOfWeek(Carbon::MONDAY);
        $endOfGrid = $endOfMonth->copy()->endOfWeek(Carbon::SUNDAY);

        $weeks = [];
        $cursor = $startOfGrid->copy();

        while ($cursor->lte($endOfGrid)) {
            $week = [];

            for ($i = 0; $i < 7; $i++) {
                $week[] = [
                    'day' => $cursor->day,
                    'isCurrentMonth' => $cursor->month === $date->month,
                    'isToday' => $cursor->isSameDay(now()),
                ];

                $cursor->addDay();
            }

            $weeks[] = $week;
        }

        return [
            'monthLabel' => $date->translatedFormat('F'),
            'year' => $date->year,
            'weekdays' => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            'weeks' => $weeks,
        ];
    }

    private function studentComposition(): array
    {
        $male = Siswa::whereRaw("LOWER(COALESCE(jenis_kelamin, '')) in ('laki-laki', 'laki laki', 'laki', 'l')")->count();
        $female = Siswa::whereRaw("LOWER(COALESCE(jenis_kelamin, '')) in ('perempuan', 'p')")->count();
        $total = max(1, $male + $female);
        $malePercent = (int) round(($male / $total) * 100);

        return [
            'male' => $male,
            'female' => $female,
            'malePercent' => $malePercent,
            'femalePercent' => 100 - $malePercent,
        ];
    }

    private function recentDocuments(array $modules): Collection
    {
        $documents = collect();

        if (in_array('penyuratan', $modules, true)) {
            $documents = $documents->merge(
                DokumenPenyuratan::with('jenis')
                    ->latest('tanggal_dokumen')
                    ->take(5)
                    ->get()
                    ->map(fn (DokumenPenyuratan $document) => [
                        'code' => $document->no_surat,
                        'name' => $document->nama_dokumen,
                        'category' => $document->jenis?->nama_jenis_surat ?? 'Penyuratan',
                        'date' => Carbon::parse($document->tanggal_dokumen),
                        'module' => 'Penyuratan',
                    ])
            );
        }

        if (in_array('keuangan', $modules, true)) {
            $documents = $documents->merge(
                DokumenKeuangan::with('kategori')
                    ->latest('tanggal_dokumen')
                    ->take(5)
                    ->get()
                    ->map(fn (DokumenKeuangan $document) => [
                        'code' => 'KEU-' . $document->id_dokumen_keuangan,
                        'name' => $document->nama_dokumen,
                        'category' => $document->kategori?->nama_kategori ?? 'Keuangan',
                        'date' => Carbon::parse($document->tanggal_dokumen),
                        'module' => 'Keuangan',
                    ])
            );
        }

        if (in_array('inventaris', $modules, true)) {
            $documents = $documents->merge(
                DokumenInventaris::latest('tanggal_dokumen')
                    ->take(5)
                    ->get()
                    ->map(fn (DokumenInventaris $document) => [
                        'code' => 'INV-' . $document->id_dokumen_inventaris,
                        'name' => $document->nama_dokumen,
                        'category' => 'Inventaris',
                        'date' => Carbon::parse($document->tanggal_dokumen),
                        'module' => 'Inventaris',
                    ])
            );
        }

        if (in_array('administrasi', $modules, true)) {
            $documents = $documents->merge(
                DokumenAdministrasi::with('jenis')
                    ->latest('tanggal_dokumen')
                    ->take(5)
                    ->get()
                    ->map(fn (DokumenAdministrasi $document) => [
                        'code' => 'ADM-' . $document->id_dokumen_administrasi,
                        'name' => $document->nama_dokumen,
                        'category' => $document->jenis?->nama_jenis ?? 'Administrasi',
                        'date' => Carbon::parse($document->tanggal_dokumen),
                        'module' => 'Administrasi',
                    ])
            );
        }

        return $documents
            ->sortByDesc(fn (array $item) => $item['date']->timestamp)
            ->take(5)
            ->values();
    }

    private function agendaFromDocuments(array $modules): Collection
    {
        return $this->recentDocuments($modules)
            ->map(fn (array $document) => [
                'dateLabel' => $document['date']->translatedFormat('d M Y'),
                'title' => $document['name'],
                'subtitle' => $document['module'] . ' • ' . $document['category'],
            ])
            ->values();
    }
}
