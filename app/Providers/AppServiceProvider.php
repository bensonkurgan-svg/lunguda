<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Behind Railway's proxy, force HTTPS so asset/auth URLs are correct.
        if (env('FORCE_HTTPS', false)) {
            URL::forceScheme('https');
        }

        Paginator::useTailwind();
    }
}
