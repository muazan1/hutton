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
            /*  dashboards module */

            // Admin Dashboard
            [
                'id' => 50,
                'name' => 'Admin Dashboard',
                'module' => 'dashboard',
                'permission' => 'adminDashboard',
                'api_permission' => 'admin:dashboard',
            ],
            // Builder Dashboard
            [
                'id' => 51,
                'name' => 'Builder Dashboard',
                'module' => 'dashboard',
                'permission' => 'buildersDashboard',
                'api_permission' => 'builder:dashboard',
            ],
            // site Dashboard
            [
                'id' => 52,
                'name' => 'Site Dashboard',
                'module' => 'dashboard',
                'permission' => 'sitesDashboard',
                'api_permission' => 'site:dashboard',
            ],
            // JOiner Dashboard
            [
                'id' => 53,
                'name' => 'Joiner Dashboard',
                'module' => 'dashboard',
                'permission' => 'joinerDashboard',
                'api_permission' => 'joiner:dashboard',
            ],

            // Joiners module
            [
                'id' => 55,
                'name' => 'Joiners view',
                'module' => 'joiners',
                'permission' => 'view',
                'api_permission' => 'joiners:view',
            ],
            [
                'id' => 56,
                'name' => 'Joiners create',
                'module' => 'joiners',
                'permission' => 'create',
                'api_permission' => 'joiners:create',
            ],
            [
                'id' => 57,
                'name' => 'Joiners edit',
                'module' => 'joiners',
                'permission' => 'edit',
                'api_permission' => 'joiners:edit',
            ],
            [
                'id' => 58,
                'name' => 'Joiners delete',
                'module' => 'joiners',
                'permission' => 'delete',
                'api_permission' => 'joiners:delete',
            ],
            [
                'id' => 59,
                'name' => 'Joiners browse',
                'module' => 'joiners',
                'permission' => 'browse',
                'api_permission' => 'joiners:browse',
            ],

            // Builders module
            [
                'id' => 60,
                'name' => 'Browse Builder',
                'module' => 'builders',
                'permission' => 'browse',
                'api_permission' => 'builders:browse',
            ],
            [
                'id' => 61,
                'name' => 'Add Builder',
                'module' => 'builders',
                'permission' => 'create',
                'api_permission' => 'builders:create',
            ],
            [
                'id' => 62,
                'name' => 'Edit Builder',
                'module' => 'builders',
                'permission' => 'edit',
                'api_permission' => 'builders:edit',
            ],
            [
                'id' => 63,
                'name' => 'Delete Builder',
                'module' => 'builders',
                'permission' => 'delete',
                'api_permission' => 'builders:delete',
            ],

            // Sites Module module
            [
                'id' => 64,
                'name' => 'Browse Sites',
                'module' => 'sites',
                'permission' => 'browse-site',
                'api_permission' => 'sites:browse',
            ],
            [
                'id' => 65,
                'name' => 'Add Sites',
                'module' => 'sites',
                'permission' => 'create',
                'api_permission' => 'sites:create',
            ],
            [
                'id' => 66,
                'name' => 'Edit Sites',
                'module' => 'sites',
                'permission' => 'edit',
                'api_permission' => 'sites:edit',
            ],
            [
                'id' => 67,
                'name' => 'Delete Sites',
                'module' => 'sites',
                'permission' => 'delete',
                'api_permission' => 'sites:delete',
            ],
            // Building types module
            [
                'id' => 64,
                'name' => 'Browse Building Types',
                'module' => 'building_types',
                'permission' => 'browse',
                'api_permission' => 'building_types:browse',
            ],
            [
                'id' => 65,
                'name' => 'Add Building Types',
                'module' => 'building_types',
                'permission' => 'create',
                'api_permission' => 'building_types:create',
            ],
            [
                'id' => 66,
                'name' => 'Edit Building Types',
                'module' => 'building_types',
                'permission' => 'edit',
                'api_permission' => 'building_types:edit',
            ],
            [
                'id' => 67,
                'name' => 'Delete Building Types',
                'module' => 'building_types',
                'permission' => 'delete',
                'api_permission' => 'building_types:delete',
            ],
            // Plots module
            [
                'id' => 64,
                'name' => 'Browse Plots',
                'module' => 'plots',
                'permission' => 'browse',
                'api_permission' => 'building_types:browse',
            ],
            [
                'id' => 65,
                'name' => 'Add Plots',
                'module' => 'plots',
                'permission' => 'create',
                'api_permission' => 'building_types:create',
            ],
            [
                'id' => 66,
                'name' => 'Edit Plots',
                'module' => 'plots',
                'permission' => 'edit',
                'api_permission' => 'building_types:edit',
            ],
            [
                'id' => 67,
                'name' => 'Delete Plots',
                'module' => 'plots',
                'permission' => 'delete',
                'api_permission' => 'building_types:delete',
            ],

            // Service Pricings module
            [
                'id' => 64,
                'name' => 'Browse Service Pricing',
                'module' => 'service_pricing',
                'permission' => 'browse',
                'api_permission' => 'service_pricing:browse',
            ],
            [
                'id' => 65,
                'name' => 'Add Service Pricing',
                'module' => 'service_pricing',
                'permission' => 'create',
                'api_permission' => 'service_pricing:create',
            ],

            // joiners Pricings module
            [
                'id' => 64,
                'name' => 'Browse Joiner Pricing',
                'module' => 'joiner_pricing',
                'permission' => 'browse',
                'api_permission' => 'joiner_pricing:browse',
            ],
            [
                'id' => 65,
                'name' => 'Add Joiner Pricing',
                'module' => 'joiner_pricing',
                'permission' => 'create',
                'api_permission' => 'joiner_pricing:create',
            ],

            // Jobs module
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

            // Services module
            [
                'id' => 64,
                'name' => 'Browse Services',
                'module' => 'services',
                'permission' => 'browse',
                'api_permission' => 'services:browse',
            ],
            [
                'id' => 65,
                'name' => 'Add Services',
                'module' => 'services',
                'permission' => 'create',
                'api_permission' => 'services:create',
            ],
            [
                'id' => 66,
                'name' => 'Edit Services',
                'module' => 'services',
                'permission' => 'edit',
                'api_permission' => 'services:edit',
            ],
            [
                'id' => 67,
                'name' => 'Delete Services',
                'module' => 'services',
                'permission' => 'delete',
                'api_permission' => 'services:delete',
            ],

            // work module
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

            /* permissions end here */
        ]);
    }
}
