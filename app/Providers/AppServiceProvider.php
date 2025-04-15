<?php

namespace App\Providers;

use App\Contracts\NowProvider;
use App\Services\ConfigBasedNowProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

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
        RateLimiter::for('now', function (Request $request) {
            return Limit::perSecond(1)->by($request->ip());
        });

        $this->app->bind(NowProvider::class, ConfigBasedNowProvider::class);

        $this->app->when(ConfigBasedNowProvider::class)
            ->needs('$fakeDatetime')
            ->give(fn () => config('app.fake_now'));
    }
}
