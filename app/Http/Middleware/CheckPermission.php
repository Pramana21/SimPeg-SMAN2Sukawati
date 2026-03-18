<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $module, $action)
    {
        $user = Auth::user();

        $hasPermission = DB::table('role_permissions')
            ->join('permissions', 'permissions.id_permission', '=', 'role_permissions.id_permission')
            ->where('role_permissions.id_role', $user->id_role)
            ->where('permissions.module', $module)
            ->where('permissions.action', $action)
            ->exists();

        if (!$hasPermission) {
            abort(403, 'Tidak memiliki akses');
        }

        return $next($request);
    }
}