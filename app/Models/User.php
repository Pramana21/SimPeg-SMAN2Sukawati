<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_user';

    protected $keyType = 'int';

    protected $fillable = [
        'username',
        'password_hash',
        'id_role',
        'id_pegawai',
        'is_active',
        'last_seen_notification',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    protected $casts = [
        'last_seen_notification' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function getAuthIdentifier()
    {
        return $this->id_user;
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }
    public function hasPermission($module, $action)
{
    return \DB::table('role_permissions')
        ->join('permissions', 'permissions.id_permission', '=', 'role_permissions.id_permission')
        ->where('role_permissions.id_role', $this->id_role)
        ->where('permissions.module', $module)
        ->where('permissions.action', $action)
        ->exists();
}
}
