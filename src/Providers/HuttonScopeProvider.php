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

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'Hutton');
    }
}
