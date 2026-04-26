<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\AuditLog;
use App\Models\DokumenAdministrasi;
use App\Models\DokumenInventaris;
use App\Models\DokumenKeuangan;
use App\Models\DokumenPenyuratan;
use App\Models\Pegawai;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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

    public function admin(Request $request): View
    {
        abort_unless(auth()->user()?->hasRole('Admin Kepegawaian'), 403, 'Tidak memiliki akses');

        return view('dashboard.dashboard-admin', $this->buildRoleDashboardPayload(
            request: $request,
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
            agendaItems: $this->dashboardAgendas(),
            sectionTitle: 'Dokumen Terbaru'
        ));
    }

    public function tamu(Request $request): View
    {
        abort_unless(auth()->user()?->hasRole('Tamu'), 403, 'Tidak memiliki akses');

        return view('dashboard.dashboard-tamu', $this->buildRoleDashboardPayload(
            request: $request,
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
            agendaItems: $this->dashboardAgendas(),
            sectionTitle: 'Dokumen yang Bisa Dipantau'
        ));
    }

    public function siswa(Request $request): View
    {
        abort_unless(auth()->user()?->hasRole('Siswa'), 403, 'Tidak memiliki akses');

        return view('dashboard.dashboard-siswa', $this->buildRoleDashboardPayload(
            request: $request,
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
            agendaItems: $this->dashboardAgendas(),
            sectionTitle: 'Dokumen Administrasi Terbaru'
        ));
    }

    private function buildRoleDashboardPayload(
        Request $request,
        string $title,
        string $subtitle,
        array $stats,
        string $roleBadge,
        Collection $recentDocuments,
        Collection $agendaItems,
        string $sectionTitle
    ): array {
        $calendarDate = $this->resolveCalendarDate($request);

        return [
            'dashboardTitle' => $title,
            'dashboardSubtitle' => $subtitle,
            'stats' => $stats,
            'roleBadge' => $roleBadge,
            'calendar' => $this->buildCalendar($calendarDate),
            'calendarMonths' => $this->calendarMonths(),
            'calendarYears' => $this->calendarYears($calendarDate->year),
            'agendaCalendarMap' => $this->agendaCalendarMap($calendarDate->month, $calendarDate->year),
            'studentComposition' => $this->studentComposition(),
            'recentDocuments' => $recentDocuments,
            'agendaItems' => $agendaItems,
            'sectionTitle' => $sectionTitle,
            'agendaCrudEnabled' => auth()->user()?->hasRole('Admin Kepegawaian') || auth()->user()?->hasRole('Tamu'),
        ];
    }

    private function resolveCalendarDate(Request $request): Carbon
    {
        $now = Carbon::now();
        $month = (int) $request->integer('month', $now->month);
        $year = (int) $request->integer('year', $now->year);

        $month = min(max($month, 1), 12);
        $year = min(max($year, $now->year - 5), $now->year + 5);

        return Carbon::create($year, $month, 1);
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
                    'date' => $cursor->format('Y-m-d'),
                    'isCurrentMonth' => $cursor->month === $date->month,
                    'isToday' => $cursor->isSameDay(now()),
                ];

                $cursor->addDay();
            }

            $weeks[] = $week;
        }

        return [
            'month' => $date->month,
            'monthLabel' => $date->translatedFormat('F'),
            'year' => $date->year,
            'weekdays' => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            'weeks' => $weeks,
        ];
    }

    private function calendarMonths(): array
    {
        $months = [];

        foreach (range(1, 12) as $month) {
            $months[$month] = Carbon::create(null, $month, 1)->translatedFormat('F');
        }

        return $months;
    }

    private function calendarYears(int $selectedYear): array
    {
        return range($selectedYear - 5, $selectedYear + 5);
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
        $queries = [];

        if (in_array('penyuratan', $modules, true)) {
            $queries[] = DB::table('dokumen_penyuratan as penyuratan')
                ->leftJoin('jenis_surat as jenis_surat', 'jenis_surat.id_jenis_surat', '=', 'penyuratan.id_jenis_surat')
                ->selectRaw("
                    penyuratan.no_surat as code,
                    penyuratan.nama_dokumen as name,
                    COALESCE(jenis_surat.nama_jenis_surat, 'Penyuratan') as category,
                    penyuratan.created_at as created_at,
                    'Penyuratan' as module
                ");
        }

        if (in_array('keuangan', $modules, true)) {
            $queries[] = DB::table('dokumen_keuangan as keuangan')
                ->leftJoin('kategori_keuangan as kategori_keuangan', 'kategori_keuangan.id_kategori_keuangan', '=', 'keuangan.id_kategori_keuangan')
                ->selectRaw("
                    CAST(keuangan.id_dokumen_keuangan as char) as code,
                    keuangan.nama_dokumen as name,
                    COALESCE(kategori_keuangan.nama_kategori, 'Keuangan') as category,
                    keuangan.created_at as created_at,
                    'Keuangan' as module
                ");
        }

        if (in_array('inventaris', $modules, true)) {
            $queries[] = DB::table('dokumen_inventaris as inventaris')
                ->selectRaw("
                    CAST(inventaris.id_dokumen_inventaris as char) as code,
                    inventaris.nama_dokumen as name,
                    'Inventaris' as category,
                    inventaris.created_at as created_at,
                    'Inventaris' as module
                ");
        }

        if (in_array('administrasi', $modules, true)) {
            $queries[] = DB::table('dokumen_administrasi as administrasi')
                ->leftJoin('jenis_dokumen_administrasi as jenis_administrasi', 'jenis_administrasi.id_jenis_dokumen_administrasi', '=', 'administrasi.id_jenis_dokumen_administrasi')
                ->selectRaw("
                    CAST(administrasi.id_dokumen_administrasi as char) as code,
                    administrasi.nama_dokumen as name,
                    COALESCE(jenis_administrasi.nama_jenis, 'Administrasi Umum') as category,
                    administrasi.created_at as created_at,
                    'Administrasi Umum' as module
                ");
        }

        if ($queries === []) {
            return collect();
        }

        $documents = array_shift($queries);

        foreach ($queries as $query) {
            $documents->unionAll($query);
        }

        return DB::query()
            ->fromSub($documents, 'docs')
            ->orderByDesc('created_at')
            ->take(5)
            ->get()
            ->map(fn ($document) => [
                'code' => $document->code,
                'name' => $document->name,
                'category' => $document->category,
                'date' => Carbon::parse($document->created_at),
                'module' => $document->module,
            ])
            ->values();
    }

    private function dashboardAgendas(): Collection
    {
        return Agenda::query()
            ->whereDate('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal')
            ->orderBy('created_at')
            ->take(5)
            ->get()
            ->map(fn (Agenda $agenda) => [
                'id' => $agenda->id,
                'tanggal' => optional($agenda->tanggal)->format('Y-m-d'),
                'tanggal_label' => optional($agenda->tanggal)->translatedFormat('d M Y'),
                'title' => $agenda->title,
                'subtitle' => collect([$agenda->waktu_kegiatan, $agenda->lokasi])->filter()->implode(' • '),
                'waktu_kegiatan' => $agenda->waktu_kegiatan,
                'lokasi' => $agenda->lokasi,
                'deskripsi' => $agenda->deskripsi,
                'dibuat_oleh' => $agenda->dibuat_oleh,
            ])
            ->values();
    }

    private function agendaCalendarMap(int $month, int $year): array
    {
        return Agenda::query()
            ->select('tanggal')
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->get()
            ->groupBy(fn (Agenda $agenda) => optional($agenda->tanggal)->format('Y-m-d'))
            ->map(fn (Collection $items) => $items->count())
            ->all();
    }
}
