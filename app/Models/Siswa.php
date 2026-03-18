<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';

    protected $fillable = [
        'nis',
        'nisn',
        'nik',
        'nama_siswa',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'email',
        'no_hp',
        'nama_ibu_kandung',
        'foto_path',
        'id_kelas',
        'is_active'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }
}
