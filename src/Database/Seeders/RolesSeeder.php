<?php
namespace Sty\Hutton\Database\Seeders;

use App\Database\Seeders\ModuleSeeder;

class RolesSeeder extends ModuleSeeder
{
    /*
     *
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $this->createRole('joiner');

        $this->createRole('supervisor');
    }
}
