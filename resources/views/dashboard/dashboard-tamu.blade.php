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
@endsection
