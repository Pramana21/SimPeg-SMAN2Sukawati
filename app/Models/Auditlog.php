<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $table = 'audit_log';
    protected $primaryKey = 'id_audit_log';

    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'action',
        'module',
        'entity',
        'entity_id',
        'description',
        'created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
