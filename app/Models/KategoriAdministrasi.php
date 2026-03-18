<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriAdministrasi extends Model
{
    protected $table = 'kategori_administrasi';
    protected $primaryKey = 'id_kategori_administrasi';

    public $timestamps = false;

    protected $fillable = ['nama_kategori'];
}
