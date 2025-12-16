<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Company;
use App\Models\User;
use App\Models\Constituency;
use App\Observers\CompanyObserver;
use App\Observers\UserObserver;
use App\Observers\ConstituencyObserver;

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
        // Register model observers for cache invalidation
        Company::observe(CompanyObserver::class);
        User::observe(UserObserver::class);
        Constituency::observe(ConstituencyObserver::class);

        // Enable query logging for slow queries in development
        if (config('app.debug')) {
            \Illuminate\Support\Facades\DB::listen(function ($query) {
                // Log queries that take longer than 1000ms (1 second)
                if ($query->time > 1000) {
                    \Illuminate\Support\Facades\Log::warning('Slow Query Detected', [
                        'sql' => $query->sql,
                        'bindings' => $query->bindings,
                        'time' => $query->time . 'ms',
                        'connection' => $query->connectionName,
                    ]);
                }
            });
        }
    }
}
