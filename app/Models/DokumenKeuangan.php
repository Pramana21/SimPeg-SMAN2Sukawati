<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenKeuangan extends Model
{
    protected $table = 'dokumen_keuangan';
    protected $primaryKey = 'id_dokumen_keuangan';

    protected $fillable = [
        'id_user',
        'nama_dokumen',
        'tanggal_dokumen',
        'id_kategori_keuangan',
        'file_path',
        'created_by',
        'bulan',
        'tahun'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriKeuangan::class, 'id_kategori_keuangan', 'id_kategori_keuangan');
    }
}
