<h1>Tambah Pegawai</h1>

<form action="{{ route('pegawai.store') }}" method="POST">
@csrf

<label>NIP</label><br>
<input type="text" name="nip"><br><br>

<label>Nama</label><br>
<input type="text" name="nama"><br><br>

<label>Jabatan</label><br>
<input type="text" name="jabatan"><br><br>

<label>Golongan</label><br>
<input type="text" name="golongan"><br><br>

<label>Unit Kerja</label><br>
<input type="text" name="unit_kerja"><br><br>

<label>Tanggal Lahir</label><br>
<input type="date" name="tanggal_lahir"><br><br>

<label>Alamat</label><br>
<textarea name="alamat"></textarea><br><br>

<label>No HP</label><br>
<input type="text" name="no_hp"><br><br>

<label>Email</label><br>
<input type="email" name="email"><br><br>

<button type="submit">Simpan</button>

</form>