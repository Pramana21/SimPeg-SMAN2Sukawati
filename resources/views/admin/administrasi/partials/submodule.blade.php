<div class="space-y-6">
    <div>
        <h1 class="text-4xl font-semibold text-slate-900">{{ $title }}</h1>
        <p class="mt-2 text-sm text-slate-500">Kelola dokumen administrasi {{ strtolower($selectedKategori) }} dengan filter bulan dan tahun yang konsisten.</p>
    </div>

    @if(session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="rounded-[28px] border border-slate-200 bg-white/90 p-5 shadow-sm">
        <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
            <div class="flex flex-wrap items-center gap-3">
                <form method="GET" action="{{ route($selectedKategori === 'Pegawai' ? 'administrasi.pegawai.index' : 'administrasi.siswa.index') }}" class="flex flex-wrap items-center gap-3">
                    <div class="relative">
                        <select name="bulan"
                                onchange="this.form.submit()"
                                class="min-w-[150px] appearance-none rounded-lg border border-blue-200 bg-blue-500 px-4 py-2.5 pr-10 text-sm font-semibold text-white outline-none transition hover:bg-blue-600">
                            <option value="">Pilih bulan</option>
                            @foreach($months as $monthValue => $monthLabel)
                                <option value="{{ $monthValue }}" {{ $selectedBulan === $monthValue ? 'selected' : '' }}>
                                    {{ $monthLabel }}
                                </option>
                            @endforeach
                        </select>
                        <i data-feather="chevron-down" class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-white"></i>
                    </div>

                    <div class="relative">
                        <select name="tahun"
                                onchange="this.form.submit()"
                                class="min-w-[120px] appearance-none rounded-lg border border-blue-200 bg-blue-500 px-4 py-2.5 pr-10 text-sm font-semibold text-white outline-none transition hover:bg-blue-600">
                            <option value="">Tahun</option>
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ $selectedTahun === $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                        <i data-feather="chevron-down" class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-white"></i>
                    </div>

                    @if($selectedBulan || $selectedTahun)
                        <a href="{{ route($selectedKategori === 'Pegawai' ? 'administrasi.pegawai.index' : 'administrasi.siswa.index') }}"
                           class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-800">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <div class="flex flex-wrap items-center gap-3 xl:justify-end">
                <form id="bulkDeleteAdministrasiForm" action="{{ route('administrasi.bulk-delete') }}" method="POST" class="hidden">
                    @csrf
                </form>

                <button type="button"
                        id="bulkDeleteAdministrasiButton"
                        class="inline-flex items-center gap-2 rounded-lg bg-red-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M6 4a2 2 0 012-2h4a2 2 0 012 2h3a1 1 0 110 2h-1v9a2 2 0 01-2 2H6a2 2 0 01-2-2V6H3a1 1 0 010-2h3zm2-1a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1H8zm-1 5a1 1 0 012 0v6a1 1 0 11-2 0V8zm4-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    Hapus Terpilih
                </button>

                <a href="{{ route($createRoute) }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                    <span class="text-lg leading-none">+</span>
                    Tambah
                </a>
            </div>
        </div>

        @include('admin.administrasi.partials.table', [
            'tableId' => $tableId,
            'emptyMessage' => $emptyMessage,
        ])
    </div>
</div>
