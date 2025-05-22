<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

class RajaOngkirServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('rajaongkir', function ($app) {
            return new Client([
                'base_uri' => 'https://api.rajaongkir.com/starter/',
                'headers' => [
                    'key' => config('services.rajaongkir.key')
                ]
            ]);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
