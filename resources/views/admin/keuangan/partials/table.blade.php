@php
    $tableId = $tableId ?? 'keuanganTable';
    $showCategory = $showCategory ?? false;
    $emptyMessage = $emptyMessage ?? 'Belum ada data.';
@endphp

<div class="mt-5 overflow-hidden rounded-[24px] border border-slate-200">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-700">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-4 text-left font-semibold text-slate-800">
                        <input type="checkbox" id="selectAll{{ $tableId }}" class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    </th>
                    <th class="px-4 py-4 text-left font-semibold text-slate-800">No</th>
                    <th class="px-4 py-4 text-left font-semibold text-slate-800">Nama Dokumen</th>
                    @if($showCategory)
                        <th class="px-4 py-4 text-left font-semibold text-slate-800">Kategori</th>
                    @endif
                    <th class="px-4 py-4 text-left font-semibold text-slate-800">Tanggal</th>
                    <th class="px-4 py-4 text-left font-semibold text-slate-800">Diupload Oleh</th>
                    <th class="px-4 py-4 text-center font-semibold text-slate-800">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse ($data as $item)
                    @php
                        $itemKategori = $item->kategori ?? ($kategori ?? null);
                    @endphp
                    <tr class="transition hover:bg-slate-50">
                        <td class="px-4 py-4 align-top">
                            <input type="checkbox"
                                   value="{{ $item->id_dokumen_keuangan }}"
                                   class="row-checkbox-{{ $tableId }} h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        </td>
                        <td class="px-4 py-4 font-medium text-slate-900">
                            {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-4 py-4">{{ $item->nama_dokumen }}</td>
                        @if($showCategory)
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                    {{ $itemKategori?->nama_kategori ?? '-' }}
                                </span>
                            </td>
                        @endif
                        <td class="px-4 py-4">{{ \Illuminate\Support\Carbon::parse($item->tanggal_dokumen)->format('d/m/Y') }}</td>
                        <td class="px-4 py-4">{{ $item->created_by }}</td>
                        <td class="px-4 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('keuangan.edit', [$itemKategori?->slug, $item->id_dokumen_keuangan]) }}"
                                   class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-green-500 px-2 py-1 text-white transition hover:bg-green-600"
                                   title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M17.414 2.586a2 2 0 010 2.828l-8.5 8.5a2 2 0 01-.878.497l-3 1a1 1 0 01-1.265-1.265l1-3a2 2 0 01.497-.878l8.5-8.5a2 2 0 012.828 0zm-9.62 8.206L5.91 12.676l-.38 1.14 1.14-.38 1.884-1.883-1.06-1.061z"/>
                                    </svg>
                                </a>

                                <a href="{{ route('keuangan.preview', [$itemKategori?->slug, $item->id_dokumen_keuangan]) }}"
                                   class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-blue-500 px-2 py-1 text-white transition hover:bg-blue-600"
                                   title="Preview">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M10 3C5.455 3 1.73 6.11.458 10c1.272 3.89 4.997 7 9.542 7s8.27-3.11 9.542-7C18.27 6.11 14.545 3 10 3zm0 11a4 4 0 110-8 4 4 0 010 8z"/>
                                        <path d="M10 8a2 2 0 100 4 2 2 0 000-4z"/>
                                    </svg>
                                </a>

                                <form action="{{ route('keuangan.delete', [$itemKategori?->slug, $item->id_dokumen_keuangan]) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-red-500 px-2 py-1 text-white transition hover:bg-red-600"
                                            title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M6 4a2 2 0 012-2h4a2 2 0 012 2h3a1 1 0 110 2h-1v9a2 2 0 01-2 2H6a2 2 0 01-2-2V6H3a1 1 0 010-2h3zm2-1a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1H8zm-1 5a1 1 0 012 0v6a1 1 0 11-2 0V8zm4-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $showCategory ? 7 : 6 }}" class="px-4 py-12 text-center text-sm text-slate-500">
                            {{ $emptyMessage }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 flex flex-col gap-3 text-sm text-slate-500 lg:flex-row lg:items-center lg:justify-between">
    <div>
        @if($data->count())
            Menampilkan {{ $data->firstItem() }} - {{ $data->lastItem() }} dari {{ $data->total() }} data
        @else
            Menampilkan 0 data
        @endif
    </div>

    <div class="flex items-center gap-4">
        <div>Panjang per halaman 10</div>
        <div>
            {{ $data->onEachSide(1)->links() }}
        </div>
    </div>
</div>

<script>
    (function () {
        const tableId = @json($tableId);
        const bulkDeleteForm = document.getElementById('bulkDeleteKeuanganForm');
        const bulkDeleteButton = document.getElementById('bulkDeleteKeuanganButton');
        const selectAllCheckbox = document.getElementById(`selectAll${tableId}`);
        const rowCheckboxes = Array.from(document.querySelectorAll(`.row-checkbox-${tableId}`));

        function syncHeaderCheckbox() {
            if (!selectAllCheckbox) {
                return;
            }

            const checkedCount = rowCheckboxes.filter((checkbox) => checkbox.checked).length;
            selectAllCheckbox.checked = rowCheckboxes.length > 0 && checkedCount === rowCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < rowCheckboxes.length;
        }

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function () {
                rowCheckboxes.forEach((checkbox) => {
                    checkbox.checked = this.checked;
                });

                syncHeaderCheckbox();
            });
        }

        rowCheckboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', syncHeaderCheckbox);
        });

        if (bulkDeleteButton && bulkDeleteForm) {
            bulkDeleteButton.addEventListener('click', function () {
                const selectedIds = rowCheckboxes
                    .filter((checkbox) => checkbox.checked)
                    .map((checkbox) => checkbox.value);

                if (selectedIds.length === 0) {
                    alert('Pilih minimal satu data keuangan untuk dihapus.');
                    return;
                }

                if (!confirm('Yakin ingin menghapus semua data keuangan yang dipilih?')) {
                    return;
                }

                bulkDeleteForm.querySelectorAll('input[name="ids[]"]').forEach((input) => input.remove());

                selectedIds.forEach((id) => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = id;
                    bulkDeleteForm.appendChild(input);
                });

                bulkDeleteForm.submit();
            });
        }

        syncHeaderCheckbox();
    })();
</script>
