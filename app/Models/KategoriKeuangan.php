<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriKeuangan extends Model
{
    protected $table = 'kategori_keuangan';
    protected $primaryKey = 'id_kategori_keuangan';

    public $timestamps = false;

    protected $fillable = [
        'nama_kategori'
    ];
}
