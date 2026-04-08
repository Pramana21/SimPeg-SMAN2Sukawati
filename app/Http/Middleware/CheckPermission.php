<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $module, ?string $action = null)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Tidak memiliki akses');
        }

        [$resolvedModule, $resolvedAction] = $this->resolveAbility($request, $module, $action);

        if (!$user->hasPermission($resolvedModule, $resolvedAction)) {
            abort(403, 'Tidak memiliki akses');
        }

        return $next($request);
    }

    private function resolveAbility(Request $request, string $module, ?string $action = null): array
    {
        if ($action !== null) {
            return [$module, $action];
        }

        if (str_contains($module, '.')) {
            return explode('.', $module, 2);
        }

        return [$module, $this->inferActionFromRequest($request)];
    }

    private function inferActionFromRequest(Request $request): string
    {
        $routeName = (string) optional($request->route())->getName();
        $method = strtoupper($request->method());

        if (
            $method === 'DELETE'
            || str_contains($routeName, 'destroy')
            || str_contains($routeName, 'delete')
            || str_contains($routeName, 'bulk-delete')
        ) {
            return 'delete';
        }

        if (
            in_array($method, ['PUT', 'PATCH'], true)
            || str_contains($routeName, '.edit')
            || str_contains($routeName, '.update')
            || str_contains($routeName, 'toggle-status')
        ) {
            return 'edit';
        }

        if (
            $method === 'POST'
            || str_contains($routeName, '.create')
            || str_contains($routeName, '.store')
        ) {
            return 'create';
        }

        return 'view';
    }
}
