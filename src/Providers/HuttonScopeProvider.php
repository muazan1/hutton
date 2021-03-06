<?php

namespace Sty\Hutton\Providers;

use Illuminate\Support\ServiceProvider;

class HuttonScopeProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // dd('Package is Working');
        // dd(database_path('seeders'));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(
            __DIR__ . '/../publishable/database/migrations',
            'migrations'
        );
        // $this->publishes([
        //     __DIR__ . '/../publishable/database/migrations' => database_path(
        //         'migrations'
        //     ),
        // ]);

        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'Hutton');

        // $this->loadViewsFrom(__DIR__ . '/../resources/views', 'blogpackage');

        $this->publishes([
            __DIR__ . '/../publishable/database/seeders' => database_path(
                'seeders'
            ),
        ]);
    }
}
