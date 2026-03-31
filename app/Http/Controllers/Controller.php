<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    protected function logActivity(string $modul, string $aktivitas, string $keterangan): void
    {
        $user = Auth::user();

        AuditLog::create([
            'user_id' => $user?->id_user ?? $user?->id ?? null,
            'nama_pengguna' => $user?->username ?? $user?->name ?? 'Guest',
            'modul' => $modul,
            'aktivitas' => $aktivitas,
            'keterangan' => $keterangan,
            'created_at' => now(),
        ]);
    }
}
