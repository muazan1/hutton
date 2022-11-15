<?php
namespace Sty\Hutton\Database\Seeders;

use App\Database\Seeders\ModuleSeeder;

class ModulesSeeder extends ModuleSeeder
{
    /*
     *
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        // Fixes Module

        $this->insertModule('fixes', 'user-group', 'Fixes');
    }
}
