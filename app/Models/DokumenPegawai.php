<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenPegawai extends Model
{

    protected $table = 'dokumen_pegawai';

    public function pegawai()
{
    return $this->belongsTo(Pegawai::class);
}
    protected $fillable = [
        'pegawai_id',
        'nama_dokumen',
        'file_dokumen'
    ];

}