<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenAdministrasi extends Model
{
    protected $table = 'dokumen_administrasi';
    protected $primaryKey = 'id_dokumen_administrasi';

    protected $fillable = [
        'id_user',
        'nama_dokumen',
        'tanggal_dokumen',
        'id_jenis_dokumen_administrasi',
        'id_kelas',
        'file_path',
        'created_by',
        'bulan',
        'tahun'
    ];
}
