<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';

    protected $fillable = [
        'nip',
        'nama',
        'jabatan',
        'golongan',
        'unit_kerja',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'email'
    ];

    public function dokumen()
    {
        return $this->hasMany(DokumenPegawai::class);
    }
}
