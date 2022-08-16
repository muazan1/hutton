<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HuttonPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('permissions')->insert([
            // Joiners
            [
                'id' => 37,
                'name' => 'Joiners view',
                'module' => 'joiners',
                'permission' => 'view',
                'api_permission' => 'joiners:view',
            ],
            [
                'id' => 38,
                'name' => 'Joiners create',
                'module' => 'joiners',
                'permission' => 'create',
                'api_permission' => 'joiners:create',
            ],
            [
                'id' => 39,
                'name' => 'Joiners edit',
                'module' => 'joiners',
                'permission' => 'edit',
                'api_permission' => 'joiners:edit',
            ],
            [
                'id' => 40,
                'name' => 'Joiners delete',
                'module' => 'joiners',
                'permission' => 'delete',
                'api_permission' => 'joiners:delete',
            ],
            [
                'id' => 41,
                'name' => 'Joiners browse',
                'module' => 'joiners',
                'permission' => 'browse',
                'api_permission' => 'joiners:browse',
            ],

            // JOiner Dashboard
            [
                'id' => 50,
                'name' => 'Joiner Dashboard',
                'module' => 'joiner',
                'permission' => 'joiner-dashboard',
                'api_permission' => 'joiner:dashboard',
            ],
            [
                'id' => 51,
                'name' => 'Weekly Work',
                'module' => 'work',
                'permission' => 'weekly-work',
                'api_permission' => 'work:weekly',
            ],
            [
                'id' => 52,
                'name' => 'My Work History',
                'module' => 'work',
                'permission' => 'work-history',
                'api_permission' => 'work:history',
            ],
            [
                'id' => 53,
                'name' => 'Daily Work',
                'module' => 'work',
                'permission' => 'daily-work',
                'api_permission' => 'work:daily',
            ],
        ]);
    }
}
