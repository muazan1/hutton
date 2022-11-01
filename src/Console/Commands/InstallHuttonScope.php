<?php

namespace Sty\Hutton\Console\Commands;

use Illuminate\Console\Command;

use Sty\Hutton\Http\Service\GenerateNewWeeks;

// use S

class InstallHuttonScope extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:huttonscope:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For Installing the Huttonscope Package with all dependencies';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Installing Hutton Scope Package');

        // Run all the Ticket migrations for the database
        $this->info('Running Migrations');
        $this->call('migrate', [
            '--path' => 'vendor/sty/hutton/src/publishable/database/migrations',
        ]);

        $this->info('Running Database Seeder');

        // Run the database seeders
        $this->info('Adding Roles...');

        $this->call('db:seed', [
            '--class' => 'Sty\Hutton\Database\Seeders\RolesSeeder',
        ]);

        $this->info('Adding Permissions...');

        $this->call('db:seed', [
            '--class' => 'Sty\Hutton\Database\Seeders\HuttonPermissionsSeeder',
        ]);

        $this->call('db:seed', [
            '--class' =>
                'Sty\Hutton\Database\Seeders\HuttonRolePermissionsSeeder',
        ]);

        return 0;
    }
}
