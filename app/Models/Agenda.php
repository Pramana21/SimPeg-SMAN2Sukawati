<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table = 'agendas';

    protected $fillable = [
        'title',
        'tanggal',
        'waktu_kegiatan',
        'lokasi',
        'deskripsi',
        'dibuat_oleh',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
}
