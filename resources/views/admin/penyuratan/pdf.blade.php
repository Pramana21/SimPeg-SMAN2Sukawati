<!DOCTYPE html>
<html>
<head>
    <title>Laporan Surat</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; }
    </style>
</head>
<body>

<h2>Laporan Penyuratan</h2>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>No Surat</th>
            <th>Nama</th>
            <th>Jenis</th>
            <th>Pengirim</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($surat as $i => $s)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $s->no_surat }}</td>
            <td>{{ $s->nama_dokumen }}</td>
            <td>{{ $s->jenis->nama_jenis_surat }}</td>
            <td>{{ $s->nama_pengirim_penerima }}</td>
            <td>{{ $s->tanggal_dokumen }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>