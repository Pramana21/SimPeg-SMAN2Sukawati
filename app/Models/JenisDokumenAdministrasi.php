<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisDokumenAdministrasi extends Model
{
    protected $table = 'jenis_dokumen_administrasi';
    protected $primaryKey = 'id_jenis_dokumen_administrasi';

    public $timestamps = false;

    protected $fillable = [
        'id_kategori_administrasi',
        'nama_jenis'
    ];
}
