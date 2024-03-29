<?php

namespace Sty\Hutton\Providers;

use Illuminate\Support\ServiceProvider;

use Sty\Hutton\Console\Commands\StartNewWeek;

use Sty\Hutton\Console\Commands\InstallHuttonScope;

class HuttonScopeProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(
            __DIR__ . '/../Database/migrations',
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

        // $this->publishes([
        //     __DIR__ . '/../publishable/database/seeders' => database_path(
        //         'seeders'
        //     ),
        // ]);

        if ($this->app->runningInConsole()) {
            $this->commands([InstallHuttonScope::class]);

            $this->commands([StartNewWeek::class]);
        }

        $this->app->register(\Barryvdh\DomPDF\ServiceProvider::class);

        $this->app->register(\Maatwebsite\Excel\ExcelServiceProvider::class);
    }
}
