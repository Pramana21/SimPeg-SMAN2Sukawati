<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisDokumenAdministrasi extends Model
{
    protected $table = 'jenis_dokumen_administrasi';
    protected $primaryKey = 'id_jenis_dokumen_administrasi';

    public $timestamps = false;

    protected $fillable = [
        'nama_jenis',
        'id_kategori_administrasi'
    ];

    public function kategori()
    {
        return $this->belongsTo(
            KategoriAdministrasi::class,
            'id_kategori_administrasi'
        );
    }
}
