<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $table = 'audit_logs';

    public $timestamps = false;

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'nama_pengguna',
        'modul',
        'aktivitas',
        'keterangan',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public static function record(?int $userId, string $modul, string $aktivitas, ?string $keterangan = null): ?self
    {
        $user = $userId ? User::query()->find($userId) : null;

        return self::create([
            'user_id' => $userId,
            'nama_pengguna' => $user?->username ?? 'Sistem',
            'modul' => $modul,
            'aktivitas' => $aktivitas,
            'keterangan' => $keterangan,
            'created_at' => now(),
        ]);
    }
}
