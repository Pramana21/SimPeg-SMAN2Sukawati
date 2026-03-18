<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id_role';

    protected $fillable = [
        'role_name',
        'description'
    ];

    // 🔥 relasi ke user
    public function users()
    {
        return $this->hasMany(User::class, 'id_role', 'id_role');
    }

    // 🔥 relasi ke permission
    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'role_permissions',
            'id_role',
            'id_permission'
        );
    }
}