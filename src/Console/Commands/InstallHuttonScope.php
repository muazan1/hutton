<?php

namespace Sty\Hutton\Console\Commands;

use Illuminate\Console\Command;

use Sty\Hutton\Http\Service\GenerateNewWeeks;

class InstallHuttonScope extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:hutton:install';

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

        // for development
        // $this->call('migrate', [
        //     '--path' => 'packages/sty/hutton/src/Database/migrations',
        // ]);

        //  for live
        // $this->call('migrate', [
        //     '--path' => 'vendor/sty/hutton/src/Database/migrations',
        // ]);

        $this->info('Running Database Seeder');

        // Run the database seeders
        $this->info('Adding Roles...');

        $this->call('db:seed', [
            '--class' => 'Sty\Hutton\Database\Seeders\RolesSeeder',
        ]);

        $this->info('Adding Modules...');

        $this->call('db:seed', [
            '--class' => 'Sty\Hutton\Database\Seeders\ModulesSeeder',
        ]);

        // $this->info('Adding Permissions...');

        // $this->call('db:seed', [
        //     '--class' => 'Sty\Hutton\Database\Seeders\HuttonPermissionsSeeder',
        // ]);

        $this->info('Installed Successfully');

        return 0;
    }
}
