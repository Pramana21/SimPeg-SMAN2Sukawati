<table class="w-full text-sm text-left">
    <thead class="text-gray-600 border-b">
        <tr>
            <th class="py-3 px-2">No</th>
            <th>Nama Dokumen</th>
            <th>Jenis</th>
            <th>Tanggal</th>
            <th>Di-upload</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>

    <tbody class="text-gray-700">

        @forelse ($data as $index => $item)
        <tr class="border-b hover:bg-gray-50">

            {{-- NOMOR --}}
            <td class="py-3 px-2">
                {{ $data->firstItem() + $index }}
            </td>

            {{-- NAMA --}}
            <td>{{ $item->nama_dokumen }}</td>

            {{-- JENIS --}}
            <td>{{ $item->kategori?->nama_kategori ?? '-' }}</td>

            {{-- TANGGAL --}}
            <td>
                {{ \Carbon\Carbon::parse($item->tanggal_dokumen)->format('d M Y') }}
            </td>

            {{-- UPLOADER --}}
            <td>{{ $item->created_by }}</td>

            {{-- AKSI --}}
            <td class="text-center space-x-2">

                {{-- PREVIEW --}}
                <a href="{{ asset('storage/' . $item->file_path) }}"
                   target="_blank"
                   class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded">
                    👁
                </a>

                {{-- DOWNLOAD --}}
                <a href="{{ asset('storage/' . $item->file_path) }}"
                   download
                   class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded">
                    ⬇
                </a>

                {{-- EDIT --}}
                <a href="{{ route('keuangan.edit', [$item->kategori?->slug, $item->id_dokumen_keuangan]) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded">
                    ✏
                </a>

                {{-- DELETE --}}
                <form action="{{ route('keuangan.delete', [$item->kategori?->slug, $item->id_dokumen_keuangan]) }}"
                      method="POST"
                      class="inline"
                      onsubmit="return confirm('Yakin hapus data ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded">
                        🗑
                    </button>
                </form>

            </td>
        </tr>

        @empty
        <tr>
            <td colspan="6" class="text-center py-6 text-gray-400">
                Belum ada data
            </td>
        </tr>
        @endforelse

    </tbody>
</table>

{{-- PAGINATION --}}
<div class="mt-4">
    {{ $data->links() }}
</div>