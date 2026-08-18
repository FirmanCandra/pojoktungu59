<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Paksa HTTPS di production (Hostinger pakai reverse proxy)
        // Tanpa ini, asset() bisa generate http:// → browser blokir gambar (mixed content)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
