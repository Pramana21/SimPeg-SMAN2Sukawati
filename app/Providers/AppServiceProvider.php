<?php

namespace App\Providers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, string $ability) {
            if (str_contains($ability, '.')) {
                return $user->hasPermission($ability);
            }

            return null;
        });

        View::composer('layouts.app', function ($view): void {
            $user = Auth::user();

            try {
                $notifications = AuditLog::query()
                    ->latest('created_at')
                    ->take(10)
                    ->get();
            } catch (\Throwable $th) {
                $notifications = collect();
            }

            $hasUnread = false;

            if ($user && $notifications->isNotEmpty()) {
                $lastSeenNotification = $user->last_seen_notification;

                $hasUnread = $lastSeenNotification === null
                    ? true
                    : AuditLog::query()
                        ->where('created_at', '>', $lastSeenNotification)
                        ->exists();
            }

            $view->with([
                'notifications' => $notifications,
                'hasUnread' => $hasUnread,
            ]);
        });
    }
}
