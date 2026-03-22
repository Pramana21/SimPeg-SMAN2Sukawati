<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenInventaris extends Model
{
    protected $table = 'dokumen_inventaris';

    protected $primaryKey = 'id_dokumen_inventaris';

    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_user',
        'nama_dokumen',
        'tanggal_dokumen',
        'file_path',
        'created_by',
        'bulan',
        'tahun'
    ];

    protected $casts = [
        'tanggal_dokumen' => 'date',
        'bulan' => 'integer',
        'tahun' => 'integer',
    ];

    // 🔥 RELASI KE USER (FIX PENTING)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}