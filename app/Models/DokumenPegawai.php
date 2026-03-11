<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenPegawai extends Model
{

    protected $table = 'dokumen_pegawai';

    protected $fillable = [
        'pegawai_id',
        'nama_dokumen',
        'file_dokumen'
    ];

}