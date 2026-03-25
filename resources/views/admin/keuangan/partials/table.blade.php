<table class="w-full text-sm text-left">
    <thead class="text-gray-600 border-b">
        <tr>
            <th class="py-3 px-2">ID</th>
            <th>Nama Dokumen</th>
            <th>Jenis Dokumen</th>
            <th>Tanggal</th>
            <th>Di-upload oleh</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>

    <tbody class="text-gray-700">

        @for ($i = 1; $i <= 5; $i++)
        <tr class="border-b hover:bg-gray-50">
            <td class="py-3 px-2">DOC{{ $i }}</td>

            {{-- AMAN (tidak pakai $kategori langsung) --}}
            <td>
                Data {{ isset($kategori) ? $kategori->nama_kategori : 'Umum' }} {{ $i }}
            </td>

            <td>
                {{ isset($kategori) ? $kategori->nama_kategori : 'Semua Kategori' }}
            </td>

            <td>01/0{{ $i }}/2025</td>
            <td>Ni Luh Surya</td>

            <td class="text-center space-x-2">
                <button class="bg-green-500 text-white px-2 py-1 rounded">✏</button>
                <button class="bg-blue-500 text-white px-2 py-1 rounded">👁</button>
                <button class="bg-red-500 text-white px-2 py-1 rounded">🗑</button>
            </td>
        </tr>
        @endfor

    </tbody>
</table>