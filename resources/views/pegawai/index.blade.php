<h1>Data Pegawai</h1>

<table border="1">
    <tr>
        <th>NIP</th>
        <th>Nama</th>
        <th>Jabatan</th>
        <th>Unit Kerja</th>
    </tr>

    @foreach($pegawai as $p)
    <tr>
        <td>{{ $p->nip }}</td>
        <td>{{ $p->nama }}</td>
        <td>{{ $p->jabatan }}</td>
        <td>{{ $p->unit_kerja }}</td>
    </tr>
    @endforeach

</table>