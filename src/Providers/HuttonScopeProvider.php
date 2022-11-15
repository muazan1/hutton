<?php

namespace Sty\Hutton\Providers;

use Illuminate\Support\ServiceProvider;

use Sty\Hutton\Console\Commands\StartNewWeek;

use Sty\Hutton\Console\Commands\InstallHuttonScope;

class HuttonScopeProvider extends ServiceProvider
{
    protected $module = 'hutton';

    protected $consoleCommands = [
        InstallHuttonScope::class,
        StartNewWeek::class,
    ];

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
        $this->registerConfig();
        $this->registerConsoleCommands();
        $this->registerRoutes();
        $this->registerViews();
        $this->registerDatabaseMigrations();
    }

    public function registerConfig()
    {
        $this->mergeConfigFrom(
            __DIR__ . "/../config/{$this->module}.php",
            $this->module
        );

        $this->publishes(
            [
                __DIR__ . '/../config/' . $this->module . '.php' => config_path(
                    "{$this->module}.php"
                ),
            ],
            "{$this->module}-config"
        );
    }

    public function registerRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
    }

    public function registerViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', $this->module);

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path(
                "views/vendor/{$this->module}"
            ),
        ]);
    }

    public function registerConsoleCommands()
    {
        if ($this->app->runningInConsole() && count($this->consoleCommands)) {
            $this->commands($this->consoleCommands);
        }
    }

    public function registerDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');

        $this->publishes(
            [
                __DIR__ . '/../Database/migrations' => database_path(
                    'migrations'
                ),
            ],
            "{$this->module}-migrations"
        );
    }
}
