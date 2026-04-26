@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <h1 class="text-4xl font-semibold text-slate-900">{{ $dashboardTitle }}</h1>
            <p class="mt-2 max-w-3xl text-sm text-slate-500">{{ $dashboardSubtitle }}</p>
        </div>

        <span class="inline-flex items-center rounded-full bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-600">
            {{ $roleBadge }}
        </span>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        @foreach ($stats as $stat)
            <div class="rounded-[24px] border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-3xl font-semibold text-slate-900">{{ $stat['value'] }}</p>
                        <p class="mt-1 text-sm text-slate-500">{{ $stat['label'] }}</p>
                    </div>

                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-500 text-white">
                        @switch($stat['icon'])
                            @case('mail-in')
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.75 7.75h14.5v8.5H4.75zm1 1 5.58 4.46a1 1 0 0 0 1.24 0l5.68-4.46" />
                                </svg>
                                @break
                            @case('mail-out')
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.75 7.75h14.5v8.5H4.75zm1 1 5.58 4.46a1 1 0 0 0 1.24 0l5.68-4.46" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.75v5.5m0 0 2.25-2.25M12 10.25 9.75 8" />
                                </svg>
                                @break
                            @case('users')
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 12.25a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7.75 17a4.25 4.25 0 0 1 8.5 0" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7.5 13.25a2 2 0 1 0-1.99-2m10.99 2a2 2 0 1 0-.01-4" />
                                </svg>
                                @break
                            @case('students')
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 11.75a2.75 2.75 0 1 0 0-5.5 2.75 2.75 0 0 0 0 5.5Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7.25 17.5a4.75 4.75 0 0 1 9.5 0" />
                                </svg>
                                @break
                            @case('wallet')
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.75 7.75A2.75 2.75 0 0 1 7.5 5h9.75a2 2 0 0 1 0 4H8.5a1.75 1.75 0 0 0 0 3.5h10.75v3.75A2.75 2.75 0 0 1 16.5 19H7.5a2.75 2.75 0 0 1-2.75-2.75z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16.75 12.5h2.5v3h-2.5a1.5 1.5 0 0 1 0-3Z" />
                                </svg>
                                @break
                            @case('archive')
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5.75 6.75h12.5v11.5a1.75 1.75 0 0 1-1.75 1.75H7.5a1.75 1.75 0 0 1-1.75-1.75z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.75 4.75h14.5v3H4.75zm4 6.5h6.5" />
                                </svg>
                                @break
                            @case('shield')
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3.75 18.25 6v4.88c0 3.67-2.6 7.02-6.25 8.37-3.65-1.35-6.25-4.7-6.25-8.37V6z" />
                                </svg>
                                @break
                            @case('badge')
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.25a3.25 3.25 0 1 0 0 6.5 3.25 3.25 0 0 0 0-6.5Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8.25 14.5h7.5l1.25 5-5-2.5-5 2.5z" />
                                </svg>
                                @break
                            @default
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5.75h4.75L17.5 9.5v8.75A1.75 1.75 0 0 1 15.75 20H9a1.75 1.75 0 0 1-1.75-1.75V7.5A1.75 1.75 0 0 1 9 5.75Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.75 5.75V9.5h3.75" />
                                </svg>
                        @endswitch
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-5 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-semibold text-slate-900">Kalender Kegiatan</h2>
                    <p class="mt-1 text-sm text-slate-500">Agenda ringan untuk satu bulan berjalan.</p>
                </div>
                <form method="GET" class="flex items-center gap-2">
                    <label class="sr-only" for="calendarMonth">Filter bulan kalender</label>
                    <select id="calendarMonth"
                            name="month"
                            onchange="this.form.submit()"
                            class="rounded-lg bg-blue-500 px-3 py-2 text-sm font-semibold text-white outline-none">
                        @foreach ($calendarMonths as $monthValue => $monthLabel)
                            <option value="{{ $monthValue }}" @selected((int) $calendar['month'] === (int) $monthValue) class="text-slate-900">
                                {{ $monthLabel }}
                            </option>
                        @endforeach
                    </select>

                    <label class="sr-only" for="calendarYear">Filter tahun kalender</label>
                    <select id="calendarYear"
                            name="year"
                            onchange="this.form.submit()"
                            class="rounded-lg bg-blue-500 px-3 py-2 text-sm font-semibold text-white outline-none">
                        @foreach ($calendarYears as $yearOption)
                            <option value="{{ $yearOption }}" @selected((int) $calendar['year'] === (int) $yearOption) class="text-slate-900">
                                {{ $yearOption }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="grid grid-cols-7 gap-2 text-center text-sm text-slate-500" id="agendaCalendarGrid">
                @foreach ($calendar['weekdays'] as $weekday)
                    <div class="py-2 font-semibold">{{ $weekday }}</div>
                @endforeach

                @foreach ($calendar['weeks'] as $week)
                    @foreach ($week as $day)
                        @php($hasAgenda = ($agendaCalendarMap[$day['date']] ?? 0) > 0)
                        <button type="button"
                                data-agenda-day
                                data-date="{{ $day['date'] }}"
                                data-is-today="{{ $day['isToday'] ? '1' : '0' }}"
                                data-is-current-month="{{ $day['isCurrentMonth'] ? '1' : '0' }}"
                                data-agenda-count="{{ $agendaCalendarMap[$day['date']] ?? 0 }}"
                                class="relative rounded-xl border px-2 py-3 font-medium transition {{ $day['isToday'] ? 'border-blue-500 bg-blue-50 text-blue-600' : ($day['isCurrentMonth'] ? 'border-slate-200 text-slate-700 hover:border-blue-200 hover:text-blue-600' : 'border-transparent bg-slate-50 text-slate-300') }}">
                            {{ $day['day'] }}

                            @if ($hasAgenda && $day['isCurrentMonth'])
                                <span data-agenda-indicator class="absolute bottom-2 left-1/2 h-1.5 w-1.5 -translate-x-1/2 rounded-full bg-blue-500"></span>
                            @endif
                        </button>
                    @endforeach
                @endforeach
            </div>
    </div>

    <div class="rounded-[28px] border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-5">
                <h2 class="text-2xl font-semibold text-slate-900">Agenda Terdekat</h2>
            </div>

            <div class="space-y-4 px-6 py-5" id="agendaList">
                @forelse ($agendaItems as $agenda)
                    <button type="button"
                            data-agenda-item
                            data-agenda-id="{{ $agenda['id'] }}"
                            class="flex w-full gap-3 rounded-2xl border border-slate-100 bg-slate-50 p-4 text-left transition hover:border-blue-200 hover:bg-blue-50">
                        <div class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 4.75v2.5m8-2.5v2.5M5.75 9.5h12.5m-11 9.75h9.5A1.75 1.75 0 0 0 18.5 17.5v-9A1.75 1.75 0 0 0 16.75 6.75H7.25A1.75 1.75 0 0 0 5.5 8.5v9c0 .97.78 1.75 1.75 1.75Z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">{{ $agenda['tanggal_label'] ?? $agenda['dateLabel'] ?? '-' }}</p>
                            <p class="mt-1 text-sm text-slate-700">{{ $agenda['title'] }}</p>
                            <p class="mt-1 text-xs text-slate-400">{{ $agenda['subtitle'] ?: 'Detail agenda tersedia di preview.' }}</p>
                        </div>
                    </button>
                @empty
                    <div id="agendaEmptyState" class="rounded-2xl border border-dashed border-slate-200 px-4 py-8 text-center text-sm text-slate-400">
                        Belum ada agenda yang tersedia.
                    </div>
                @endforelse
            </div>
        </div>

    <div class="rounded-[28px] border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-5">
            <h2 class="text-2xl font-semibold text-slate-900">{{ $sectionTitle }}</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-700">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-slate-800">Kode</th>
                        <th class="px-6 py-4 text-left font-semibold text-slate-800">Nama Dokumen</th>
                        <th class="px-6 py-4 text-left font-semibold text-slate-800">Kategori</th>
                        <th class="px-6 py-4 text-left font-semibold text-slate-800">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse ($recentDocuments as $document)
                        <tr class="transition hover:bg-slate-50">
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $document['code'] }}</td>
                            <td class="px-6 py-4">{{ $document['name'] }}</td>
                            <td class="px-6 py-4">{{ $document['category'] }}</td>
                            <td class="px-6 py-4">{{ $document['date']->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-slate-400">
                                Belum ada dokumen yang dapat ditampilkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-2xl font-semibold text-slate-900">Komposisi Murid</h2>
        <div class="mt-8 flex flex-col items-center gap-6">
            <div class="h-56 w-56 rounded-full border-8 border-white shadow-inner"
                 style="background: conic-gradient(#2563eb 0 {{ $studentComposition['malePercent'] }}%, #93c5fd {{ $studentComposition['malePercent'] }}% 100%);">
            </div>

            <div class="flex flex-wrap items-center justify-center gap-6 text-sm text-slate-600">
                <div class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-blue-600"></span>
                    Laki-laki ({{ $studentComposition['male'] }})
                </div>
                <div class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-blue-300"></span>
                    Perempuan ({{ $studentComposition['female'] }})
                </div>
            </div>
        </div>
    </div>
</div>

<div id="agendaBackdrop" class="fixed inset-0 z-40 hidden bg-slate-900/40 backdrop-blur-[2px]"></div>

<div id="agendaFormModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="relative w-full max-w-2xl rounded-[28px] border border-slate-200 bg-white shadow-2xl">
        <button type="button" data-close-agenda-modal class="absolute right-5 top-5 inline-flex h-10 w-10 items-center justify-center rounded-full text-slate-400 transition hover:bg-slate-100 hover:text-slate-600">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="border-b border-slate-200 px-6 py-5 pr-20">
            <h3 id="agendaFormTitle" class="text-2xl font-semibold text-slate-900">Tambah Agenda</h3>
            <p class="mt-1 text-sm text-slate-500">Lengkapi detail agenda tanpa mengubah tampilan dashboard utama.</p>
        </div>

        <form id="agendaForm" class="space-y-5 px-6 py-6">
            <input type="hidden" id="agendaMethod" value="POST">
            <input type="hidden" id="agendaEditId" value="">

            <div id="agendaFormError" class="hidden rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700"></div>

            <div class="space-y-2">
                <label for="agendaTitle" class="text-sm font-semibold text-slate-700">Judul</label>
                <input id="agendaTitle" name="title" type="text" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100" required>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div class="space-y-2">
                    <label for="agendaTanggal" class="text-sm font-semibold text-slate-700">Tanggal</label>
                    <input id="agendaTanggal" name="tanggal" type="date" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100" required>
                </div>

                <div class="space-y-2">
                    <label for="agendaWaktu" class="text-sm font-semibold text-slate-700">Waktu Kegiatan</label>
                    <input id="agendaWaktu" name="waktu_kegiatan" type="text" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100" placeholder="Contoh: 09.00 - 11.00 WIB">
                </div>
            </div>

            <div class="space-y-2">
                <label for="agendaLokasi" class="text-sm font-semibold text-slate-700">Lokasi</label>
                <input id="agendaLokasi" name="lokasi" type="text" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
            </div>

            <div class="space-y-2">
                <label for="agendaDeskripsi" class="text-sm font-semibold text-slate-700">Deskripsi</label>
                <textarea id="agendaDeskripsi" name="deskripsi" rows="4" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"></textarea>
            </div>

            <div class="space-y-2">
                <label for="agendaDibuatOleh" class="text-sm font-semibold text-slate-700">Dibuat Oleh</label>
                <input id="agendaDibuatOleh" type="text" value="{{ auth()->user()->username ?? '-' }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500" readonly>
            </div>

            <div class="flex justify-end gap-3 border-t border-slate-200 pt-5">
                <button type="button" data-close-agenda-modal class="inline-flex items-center rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50">
                    Batal
                </button>
                <button type="submit" class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                    Simpan Agenda
                </button>
            </div>
        </form>
    </div>
</div>

<div id="agendaPreviewModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="relative w-full max-w-2xl rounded-[28px] border border-slate-200 bg-white shadow-2xl">
        <button type="button" data-close-agenda-modal class="absolute right-5 top-5 inline-flex h-10 w-10 items-center justify-center rounded-full text-slate-400 transition hover:bg-slate-100 hover:text-slate-600">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="flex items-start justify-between gap-4 border-b border-slate-200 px-6 py-5 pr-24">
            <div>
                <h3 id="agendaPreviewHeading" class="text-2xl font-semibold text-slate-900">Preview Agenda</h3>
                <p id="agendaPreviewDate" class="mt-2 text-sm text-slate-500"></p>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" id="agendaPreviewEdit" class="inline-flex h-10 w-10 items-center justify-center rounded-full text-slate-500 transition hover:bg-blue-50 hover:text-blue-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.75 19.25h4.5L18 10.5 13.5 6 4.75 14.75zM12.75 6.75 17.25 11.25" />
                    </svg>
                </button>
                <button type="button" id="agendaPreviewDelete" class="inline-flex h-10 w-10 items-center justify-center rounded-full text-slate-500 transition hover:bg-rose-50 hover:text-rose-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5.75h6m-7 3h8m-7.25 0v8.5m3.5-8.5v8.5m3.75-11.5v12a1.75 1.75 0 0 1-1.75 1.75H8.5A1.75 1.75 0 0 1 6.75 17.75v-12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="space-y-5 px-6 py-6">
            <div class="rounded-2xl bg-slate-50 px-4 py-4">
                <p id="agendaPreviewTitle" class="text-xl font-semibold text-slate-900"></p>
                <p id="agendaPreviewTime" class="mt-2 text-sm text-slate-500"></p>
            </div>

            <div class="space-y-4 text-sm text-slate-700">
                <div class="flex gap-3">
                    <div class="mt-0.5 text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 20.25c3.5-4.3 5.25-7.3 5.25-9.25a5.25 5.25 0 1 0-10.5 0c0 1.95 1.75 4.95 5.25 9.25Z" />
                            <circle cx="12" cy="11" r="1.75" stroke-width="1.8" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-900">Lokasi</p>
                        <p id="agendaPreviewLocation" class="mt-1 text-slate-500">-</p>
                    </div>
                </div>

                <div class="flex gap-3">
                    <div class="mt-0.5 text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 8.75h10M7 12h10m-10 3.25h6.5" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-900">Deskripsi</p>
                        <p id="agendaPreviewDescription" class="mt-1 whitespace-pre-line text-slate-500">-</p>
                    </div>
                </div>

                <div class="flex gap-3">
                    <div class="mt-0.5 text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 12.25a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.25 6a5.25 5.25 0 0 1 10.5 0" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-900">Dibuat Oleh</p>
                        <p id="agendaPreviewCreator" class="mt-1 text-slate-500">-</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (() => {
        const userRole = "{{ auth()->user()->role }}";
        const isTamu = userRole === 'tamu';
        const agendaConfig = {
            csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            baseUrl: @json(url('/agenda')),
            listUrl: @json(route('agenda.index')),
            initialAgendas: @json($agendaItems),
            initialCalendarMap: @json($agendaCalendarMap),
            currentCalendarMonth: @json((int) $calendar['month']),
            currentCalendarYear: @json((int) $calendar['year']),
            crudEnabled: @json($agendaCrudEnabled),
            currentUsername: @json(auth()->user()->username ?? '-'),
        };

        const agendaBackdrop = document.getElementById('agendaBackdrop');
        const agendaFormModal = document.getElementById('agendaFormModal');
        const agendaPreviewModal = document.getElementById('agendaPreviewModal');
        const agendaForm = document.getElementById('agendaForm');
        const agendaFormTitle = document.getElementById('agendaFormTitle');
        const agendaFormError = document.getElementById('agendaFormError');
        const agendaEditIdInput = document.getElementById('agendaEditId');
        const agendaMethodInput = document.getElementById('agendaMethod');
        const agendaTitleInput = document.getElementById('agendaTitle');
        const agendaTanggalInput = document.getElementById('agendaTanggal');
        const agendaWaktuInput = document.getElementById('agendaWaktu');
        const agendaLokasiInput = document.getElementById('agendaLokasi');
        const agendaDeskripsiInput = document.getElementById('agendaDeskripsi');
        const agendaDibuatOlehInput = document.getElementById('agendaDibuatOleh');
        const agendaList = document.getElementById('agendaList');
        const calendarButtons = Array.from(document.querySelectorAll('[data-agenda-day]'));
        const previewDate = document.getElementById('agendaPreviewDate');
        const previewTitle = document.getElementById('agendaPreviewTitle');
        const previewTime = document.getElementById('agendaPreviewTime');
        const previewLocation = document.getElementById('agendaPreviewLocation');
        const previewDescription = document.getElementById('agendaPreviewDescription');
        const previewCreator = document.getElementById('agendaPreviewCreator');
        const previewEditButton = document.getElementById('agendaPreviewEdit');
        const previewDeleteButton = document.getElementById('agendaPreviewDelete');
        const closeButtons = document.querySelectorAll('[data-close-agenda-modal]');

        if (!agendaBackdrop || !agendaFormModal || !agendaPreviewModal || !agendaList || !agendaForm) {
            return;
        }

        let agendas = Array.isArray(agendaConfig.initialAgendas) ? agendaConfig.initialAgendas : [];
        let agendaCalendarMap = agendaConfig.initialCalendarMap || {};
        let activeAgenda = null;
        let selectedDate = null;

        const requestHeaders = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': agendaConfig.csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
        };

        const formatEmptyText = (value, fallback = '-') => value && value.trim() !== '' ? value : fallback;
        const isDateInActiveCalendar = (date) => {
            if (!date) {
                return false;
            }

            const [year, month] = date.split('-').map(Number);

            return year === Number(agendaConfig.currentCalendarYear)
                && month === Number(agendaConfig.currentCalendarMonth);
        };

        const applyCalendarButtonState = (button, isSelected = false) => {
            const isToday = button.dataset.isToday === '1';
            const isCurrentMonth = button.dataset.isCurrentMonth === '1';

            button.classList.remove(
                'border-blue-500',
                'bg-blue-50',
                'text-blue-600',
                'border-slate-200',
                'text-slate-700',
                'hover:border-blue-200',
                'hover:text-blue-600',
                'border-transparent',
                'bg-slate-50',
                'text-slate-300'
            );

            if (isSelected || isToday) {
                button.classList.add('border-blue-500', 'bg-blue-50', 'text-blue-600');
                return;
            }

            if (isCurrentMonth) {
                button.classList.add('border-slate-200', 'text-slate-700', 'hover:border-blue-200', 'hover:text-blue-600');
                return;
            }

            button.classList.add('border-transparent', 'bg-slate-50', 'text-slate-300');
        };

        const highlightSelectedDate = (date) => {
            selectedDate = date;
            calendarButtons.forEach((button) => {
                applyCalendarButtonState(button, button.dataset.date === date);
            });
        };

        const closeAllModals = () => {
            agendaBackdrop.classList.add('hidden');
            agendaFormModal.classList.add('hidden');
            agendaFormModal.classList.remove('flex');
            agendaPreviewModal.classList.add('hidden');
            agendaPreviewModal.classList.remove('flex');
            agendaFormError.classList.add('hidden');
            agendaFormError.textContent = '';
        };

        const openFormModal = (mode, agenda = null, forcedDate = null) => {
            if (isTamu || !agendaConfig.crudEnabled) {
                return;
            }

            agendaForm.reset();
            agendaFormError.classList.add('hidden');
            agendaFormError.textContent = '';
            agendaDibuatOlehInput.value = agendaConfig.currentUsername;
            agendaMethodInput.value = mode === 'edit' ? 'PUT' : 'POST';
            agendaEditIdInput.value = agenda?.id || '';
            agendaFormTitle.textContent = mode === 'edit' ? 'Edit Agenda' : 'Tambah Agenda';
            agendaTitleInput.value = agenda?.title || '';
            agendaTanggalInput.value = agenda?.tanggal || forcedDate || selectedDate || '';
            agendaWaktuInput.value = agenda?.waktu_kegiatan || '';
            agendaLokasiInput.value = agenda?.lokasi || '';
            agendaDeskripsiInput.value = agenda?.deskripsi || '';

            agendaBackdrop.classList.remove('hidden');
            agendaFormModal.classList.remove('hidden');
            agendaFormModal.classList.add('flex');
            agendaPreviewModal.classList.add('hidden');
            agendaPreviewModal.classList.remove('flex');
        };

        const openPreviewModal = (agenda) => {
            if (isTamu) {
                return;
            }

            activeAgenda = agenda;
            previewDate.textContent = agenda.tanggal_label || '-';
            previewTitle.textContent = agenda.title || '-';
            previewTime.textContent = formatEmptyText(agenda.waktu_kegiatan, 'Waktu kegiatan belum diisi.');
            previewLocation.textContent = formatEmptyText(agenda.lokasi);
            previewDescription.textContent = formatEmptyText(agenda.deskripsi);
            previewCreator.textContent = formatEmptyText(agenda.dibuat_oleh);

            agendaBackdrop.classList.remove('hidden');
            agendaPreviewModal.classList.remove('hidden');
            agendaPreviewModal.classList.add('flex');
            agendaFormModal.classList.add('hidden');
            agendaFormModal.classList.remove('flex');
        };

        const renderAgendaList = () => {
            if (!agendas.length) {
                agendaList.innerHTML = '<div id="agendaEmptyState" class="rounded-2xl border border-dashed border-slate-200 px-4 py-8 text-center text-sm text-slate-400">Belum ada agenda yang tersedia.</div>';
                return;
            }

            agendaList.innerHTML = agendas.map((agenda) => `
                <button type="button" data-agenda-item data-agenda-id="${agenda.id}" class="flex w-full gap-3 rounded-2xl border border-slate-100 bg-slate-50 p-4 text-left transition hover:border-blue-200 hover:bg-blue-50">
                    <div class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 4.75v2.5m8-2.5v2.5M5.75 9.5h12.5m-11 9.75h9.5A1.75 1.75 0 0 0 18.5 17.5v-9A1.75 1.75 0 0 0 16.75 6.75H7.25A1.75 1.75 0 0 0 5.5 8.5v9c0 .97.78 1.75 1.75 1.75Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-900">${agenda.tanggal_label || '-'}</p>
                        <p class="mt-1 text-sm text-slate-700">${agenda.title || '-'}</p>
                        <p class="mt-1 text-xs text-slate-400">${agenda.subtitle && agenda.subtitle.trim() !== '' ? agenda.subtitle : 'Detail agenda tersedia di preview.'}</p>
                    </div>
                </button>
            `).join('');
        };

        const attachAgendaItemListeners = () => {
            document.querySelectorAll('[data-agenda-item]').forEach((button) => {
                if (isTamu) {
                    button.classList.remove('hover:border-blue-200', 'hover:bg-blue-50');
                    button.classList.add('cursor-default');
                    return;
                }

                button.addEventListener('click', async () => {
                    try {
                        const response = await fetch(`${agendaConfig.baseUrl}/${button.dataset.agendaId}`, {
                            headers: requestHeaders,
                        });
                        const payload = await response.json();

                        if (!response.ok) {
                            throw new Error(payload.message || 'Gagal memuat agenda.');
                        }

                        openPreviewModal(payload.data);
                    } catch (error) {
                        alert(error.message || 'Gagal memuat agenda.');
                    }
                });
            });
        };

        const refreshAgendaList = async () => {
            const params = new URLSearchParams({
                date_from: new Date().toISOString().slice(0, 10),
                limit: '5',
            });

            const response = await fetch(`${agendaConfig.listUrl}?${params.toString()}`, {
                headers: requestHeaders,
            });
            const payload = await response.json();

            if (!response.ok) {
                throw new Error(payload.message || 'Gagal memuat ulang agenda.');
            }

            agendas = Array.isArray(payload.data) ? payload.data : [];
            renderAgendaList();
            attachAgendaItemListeners();
        };

        const updateCalendarCount = (date, delta) => {
            if (!date) {
                return;
            }

            const nextValue = Math.max(0, Number(agendaCalendarMap[date] || 0) + delta);
            if (nextValue === 0) {
                delete agendaCalendarMap[date];
            } else {
                agendaCalendarMap[date] = nextValue;
            }

            calendarButtons.forEach((button) => {
                if (button.dataset.date !== date) {
                    return;
                }

                const isActiveCalendarDate = isDateInActiveCalendar(date) && button.dataset.isCurrentMonth === '1';
                button.dataset.agendaCount = String(isActiveCalendarDate ? (agendaCalendarMap[date] || 0) : 0);

                let indicator = button.querySelector('[data-agenda-indicator]');
                if (isActiveCalendarDate && (agendaCalendarMap[date] || 0) > 0) {
                    if (!indicator) {
                        indicator = document.createElement('span');
                        indicator.dataset.agendaIndicator = '1';
                        indicator.className = 'absolute bottom-2 left-1/2 h-1.5 w-1.5 -translate-x-1/2 rounded-full bg-blue-500';
                        button.appendChild(indicator);
                    }
                } else if (indicator) {
                    indicator.remove();
                }
            });
        };

        calendarButtons.forEach((button) => {
            button.addEventListener('click', () => {
                if (isTamu) {
                    return;
                }

                const date = button.dataset.date;
                highlightSelectedDate(date);

                if (agendaConfig.crudEnabled) {
                    openFormModal('create', null, date);
                }
            });
        });

        closeButtons.forEach((button) => {
            button.addEventListener('click', closeAllModals);
        });

        agendaBackdrop.addEventListener('click', closeAllModals);

        agendaFormModal.addEventListener('click', (event) => {
            event.stopPropagation();
        });

        agendaPreviewModal.addEventListener('click', (event) => {
            event.stopPropagation();
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeAllModals();
            }
        });

        previewEditButton?.addEventListener('click', () => {
            if (isTamu || !activeAgenda || !agendaConfig.crudEnabled) {
                return;
            }

            openFormModal('edit', activeAgenda);
        });

        previewDeleteButton?.addEventListener('click', async () => {
            if (isTamu || !activeAgenda || !agendaConfig.crudEnabled) {
                return;
            }

            const confirmed = window.confirm(`Hapus agenda "${activeAgenda.title}"?`);
            if (!confirmed) {
                return;
            }

            try {
                const response = await fetch(`${agendaConfig.baseUrl}/${activeAgenda.id}`, {
                    method: 'DELETE',
                    headers: requestHeaders,
                });
                const payload = await response.json();

                if (!response.ok) {
                    throw new Error(payload.message || 'Gagal menghapus agenda.');
                }

                updateCalendarCount(activeAgenda.tanggal, -1);
                activeAgenda = null;
                closeAllModals();
                await refreshAgendaList();
            } catch (error) {
                alert(error.message || 'Gagal menghapus agenda.');
            }
        });

        agendaForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            if (isTamu) {
                return;
            }

            agendaFormError.classList.add('hidden');
            agendaFormError.textContent = '';

            const payload = {
                title: agendaTitleInput.value.trim(),
                tanggal: agendaTanggalInput.value,
                waktu_kegiatan: agendaWaktuInput.value.trim(),
                lokasi: agendaLokasiInput.value.trim(),
                deskripsi: agendaDeskripsiInput.value.trim(),
            };

            const isEdit = agendaMethodInput.value === 'PUT' && agendaEditIdInput.value !== '';
            const previousAgenda = isEdit ? activeAgenda : null;
            const endpoint = isEdit ? `${agendaConfig.baseUrl}/${agendaEditIdInput.value}` : agendaConfig.baseUrl;

            try {
                const response = await fetch(endpoint, {
                    method: isEdit ? 'PUT' : 'POST',
                    headers: requestHeaders,
                    body: JSON.stringify(payload),
                });
                const result = await response.json();

                if (!response.ok) {
                    if (result.errors) {
                        const messages = Object.values(result.errors).flat().join(' ');
                        throw new Error(messages || result.message || 'Data agenda tidak valid.');
                    }

                    throw new Error(result.message || 'Gagal menyimpan agenda.');
                }

                const savedAgenda = result.data;

                if (isEdit && previousAgenda?.tanggal && previousAgenda.tanggal !== savedAgenda.tanggal) {
                    updateCalendarCount(previousAgenda.tanggal, -1);
                    updateCalendarCount(savedAgenda.tanggal, 1);
                } else if (!isEdit) {
                    updateCalendarCount(savedAgenda.tanggal, 1);
                }

                activeAgenda = savedAgenda;
                highlightSelectedDate(savedAgenda.tanggal);
                closeAllModals();
                await refreshAgendaList();
            } catch (error) {
                agendaFormError.textContent = error.message || 'Gagal menyimpan agenda.';
                agendaFormError.classList.remove('hidden');
            }
        });

        renderAgendaList();
        attachAgendaItemListeners();
        highlightSelectedDate(calendarButtons.find((button) => button.dataset.isToday === '1')?.dataset.date || calendarButtons.find((button) => button.dataset.isCurrentMonth === '1')?.dataset.date || null);
    })();
</script>
@endsection
