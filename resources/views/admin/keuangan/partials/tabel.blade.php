<table class="w-full border">
    <thead>
        <tr class="bg-gray-200">
            <th>ID</th>
            <th>Nama Dokumen</th>
            <th>Kategori</th>
            <th>Tanggal</th>
            <th>Upload Oleh</th>
        </tr>
    </thead>

    <tbody>
        @foreach($data as $item)
        <tr class="border-t">
            <td>{{ $item->id_dokumen_keuangan }}</td>
            <td>{{ $item->nama_dokumen }}</td>
            <td>{{ $item->kategori->nama_kategori }}</td>
            <td>{{ $item->tanggal_dokumen }}</td>
            <td>{{ $item->created_by }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $data->links() }}
</div>