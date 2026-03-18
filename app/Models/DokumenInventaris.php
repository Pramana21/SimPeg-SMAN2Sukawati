<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenInventaris extends Model
{
    protected $table = 'dokumen_inventaris';
    protected $primaryKey = 'id_dokumen_inventaris';

    protected $fillable = [
        'id_user',
        'nama_dokumen',
        'tanggal_dokumen',
        'file_path',
        'created_by',
        'bulan',
        'tahun'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
