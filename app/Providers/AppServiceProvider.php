<?php

namespace App\Providers;

use App\Manager\Drivers\KayneWestDriver;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(KayneWestDriver::class, function (Application $app) {
            $client = Http::withOptions([
                'base_uri' => config('app.kayne_west.url'),
                'timeout' => 10,
                'connect_timeout' => 2,
            ]);

            return new KayneWestDriver($client);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
