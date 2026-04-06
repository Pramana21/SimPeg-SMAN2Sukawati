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
        'file_path',
        'created_by',
        'kelas',
        'kategori_kelas',
        'bulan',
        'tahun'
    ];

    public function jenis()
    {
        return $this->belongsTo(
            JenisDokumenAdministrasi::class,
            'id_jenis_dokumen_administrasi'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
