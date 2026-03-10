<h1>Edit Pegawai</h1>

<form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">

@csrf
@method('PUT')

<label>NIP</label><br>
<input type="text" name="nip" value="{{ $pegawai->nip }}"><br><br>

<label>Nama</label><br>
<input type="text" name="nama" value="{{ $pegawai->nama }}"><br><br>

<label>Jabatan</label><br>
<input type="text" name="jabatan" value="{{ $pegawai->jabatan }}"><br><br>

<label>Golongan</label><br>
<input type="text" name="golongan" value="{{ $pegawai->golongan }}"><br><br>

<label>Unit Kerja</label><br>
<input type="text" name="unit_kerja" value="{{ $pegawai->unit_kerja }}"><br><br>

<label>Tanggal Lahir</label><br>
<input type="date" name="tanggal_lahir" value="{{ $pegawai->tanggal_lahir }}"><br><br>

<label>Alamat</label><br>
<textarea name="alamat">{{ $pegawai->alamat }}</textarea><br><br>

<label>No HP</label><br>
<input type="text" name="no_hp" value="{{ $pegawai->no_hp }}"><br><br>

<label>Email</label><br>
<input type="email" name="email" value="{{ $pegawai->email }}"><br><br>

<button type="submit">Update</button>

</form>