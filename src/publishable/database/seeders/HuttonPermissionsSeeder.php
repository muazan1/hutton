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

            // Admin Dashboard
            [
                'id' => 47,
                'name' => 'Admin Dashboard',
                'module' => 'dashboard',
                'permission' => 'admin-dashboard',
                'api_permission' => 'admin:dashboard',
            ],
            // Builder Dashboard
            [
                'id' => 48,
                'name' => 'Builder Dashboard',
                'module' => 'dashboard',
                'permission' => 'builder-dashboard',
                'api_permission' => 'builder:dashboard',
            ],
            // site Dashboard
            [
                'id' => 49,
                'name' => 'Site Dashboard',
                'module' => 'dashboard',
                'permission' => 'site-dashboard',
                'api_permission' => 'site:dashboard',
            ],
            // JOiner Dashboard
            [
                'id' => 50,
                'name' => 'Joiner Dashboard',
                'module' => 'dashbaord',
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
            [
                'id' => 54,
                'name' => 'Jobs',
                'module' => 'jobs',
                'permission' => 'joiner-jobs',
                'api_permission' => 'joiner:jobs',
            ],
            [
                'id' => 55,
                'name' => 'Admin Jobs',
                'module' => 'jobs',
                'permission' => 'admin-jobs',
                'api_permission' => 'admin:jobs',
            ],

            // Builders Module
            [
                'id' => 60,
                'name' => 'Browse Builder',
                'module' => 'builders',
                'permission' => 'browse-builder',
                'api_permission' => 'builder:browse',
            ],
            [
                'id' => 61,
                'name' => 'Add Builder',
                'module' => 'builders',
                'permission' => 'add-builder',
                'api_permission' => 'builder:create',
            ],
            [
                'id' => 62,
                'name' => 'Edit Builder',
                'module' => 'builders',
                'permission' => 'edit-builder',
                'api_permission' => 'builder:edit',
            ],
            [
                'id' => 63,
                'name' => 'Delete Builder',
                'module' => 'builders',
                'permission' => 'delete-builder',
                'api_permission' => 'builder:delete',
            ],
        ]);
    }
}
