<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenPenyuratan extends Model
{
    protected $table = 'dokumen_penyuratan';

    protected $primaryKey = 'id_dokumen_penyuratan';

    protected $fillable = [
        'id_user',
        'nama_dokumen',
        'no_surat',
        'tanggal_dokumen',
        'id_jenis_surat',
        'nama_pengirim_penerima',
        'file_path',
        'created_by',
        'bulan',
        'tahun'
    ];

    /**
     * 🔥 RELASI KE JENIS SURAT
     */
    public function jenis()
    {
        return $this->belongsTo(JenisSurat::class, 'id_jenis_surat', 'id_jenis_surat');
    }

    /**
     * 🔥 OPTIONAL (BAGUS UNTUK NEXT)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}