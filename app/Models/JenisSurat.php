<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    protected $table = 'jenis_surat';
    protected $primaryKey = 'id_jenis_surat';

    public $timestamps = false;

    protected $fillable = [
        'nama_jenis_surat'
    ];

    public function dokumen()
    {
        return $this->hasMany(DokumenPenyuratan::class, 'id_jenis_surat');
    }
}
