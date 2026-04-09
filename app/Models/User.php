<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

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

    protected static function booted(): void
    {
        static::saved(function (self $user): void {
            $user->syncRoleAssignmentRecord();
        });

        static::deleted(function (self $user): void {
            if (!DB::getSchemaBuilder()->hasTable('model_has_roles')) {
                return;
            }

            DB::table('model_has_roles')
                ->where('id_user', $user->id_user)
                ->delete();
        });
    }

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

    public function hasRole(string $roleName): bool
    {
        return strcasecmp((string) optional($this->role)->role_name, $roleName) === 0;
    }

    public function dashboardRouteName(): string
    {
        if ($this->hasRole('Admin Kepegawaian')) {
            return 'dashboard.admin';
        }

        if ($this->hasRole('Tamu')) {
            return 'dashboard.tamu';
        }

        if ($this->hasRole('Siswa')) {
            return 'dashboard.siswa';
        }

        return 'dashboard';
    }

    public function hasPermission(string $module, ?string $action = null): bool
    {
        if ($action === null && str_contains($module, '.')) {
            [$module, $action] = explode('.', $module, 2);
        }

        if (!$module || !$action || !$this->id_role) {
            return false;
        }

        $candidateModules = $this->resolvePermissionModuleAliases($module);

        return DB::table('role_permissions')
            ->join('permissions', 'permissions.id_permission', '=', 'role_permissions.id_permission')
            ->where('role_permissions.id_role', $this->id_role)
            ->whereIn('permissions.module', $candidateModules)
            ->where('permissions.action', $action)
            ->exists();
    }

    protected function resolvePermissionModuleAliases(string $module): array
    {
        $aliases = [
            'dashboard' => ['dashboard'],
            'role_akses' => ['role_akses', 'role'],
            'role' => ['role', 'role_akses'],
            'manajemen_user' => ['manajemen_user', 'user'],
            'user' => ['user', 'manajemen_user'],
            'audit_log' => ['audit_log'],
            'penyuratan' => ['penyuratan'],
            'keuangan' => ['keuangan'],
            'inventaris' => ['inventaris'],
            'data_center' => ['data_center'],
            'administrasi_umum' => ['administrasi_umum', 'administrasi'],
            'administrasi' => ['administrasi', 'administrasi_umum'],
            'administrasi_umum_pegawai' => ['administrasi_umum_pegawai', 'pegawai'],
            'pegawai' => ['pegawai', 'administrasi_umum_pegawai'],
            'administrasi_umum_siswa' => ['administrasi_umum_siswa', 'siswa'],
            'siswa' => ['siswa', 'administrasi_umum_siswa'],
        ];

        return array_values(array_unique($aliases[$module] ?? [$module]));
    }

    protected function syncRoleAssignmentRecord(): void
    {
        if (!$this->id_user || !$this->id_role || !DB::getSchemaBuilder()->hasTable('model_has_roles')) {
            return;
        }

        DB::table('model_has_roles')
            ->updateOrInsert(
                ['id_user' => $this->id_user],
                [
                    'id_role' => $this->id_role,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
    }
}
