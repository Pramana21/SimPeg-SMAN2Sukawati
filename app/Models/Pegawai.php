<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    protected $primaryKey = 'id_pegawai';

    protected $fillable = [
        'nip_nippk',
        'nik',
        'nuptk',
        'nama_pegawai',
        'tanggal_lahir',
        'jenis_kelamin',
        'status_pegawai',
        'pendidikan_terakhir',
        'alamat',
        'email',
        'no_hp',
        'foto_path',
        'is_active'
    ];

    // relasi ke user
    public function user()
    {
        return $this->hasOne(User::class, 'id_pegawai', 'id_pegawai');
    }
}
