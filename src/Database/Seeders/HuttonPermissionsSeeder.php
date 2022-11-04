<?php

namespace Sty\Hutton\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Database\Seeders\ModuleSeeder;

class HuttonPermissionsSeeder extends ModuleSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $map = [
            'admin-dashboard' => $this->insertPermission('Admin Dashboard', 'dashboard', 'adminDashboard', 'admin:dashboard'),
            'builder-dashboard' => $this->insertPermission('Builder Dashboard', 'dashboard', 'buildersDashboard', 'builder:dashboard'),
            'site-dashboard'    => $this->insertPermission('Site Dashboard', 'dashboard', 'buildersDashboard', 'builder:dashboard'),
            'joiner-dashboard'  => $this->insertPermission('Joiner Dashboard', 'dashboard', 'joinerDashboard', 'joiner:dashboard'),
            'joiners-view'      => $this->insertPermission('Joiners view', 'joiners', 'view', 'joiners:view'),
            'joiners-create'    => $this->insertPermission('Joiners create', 'joiners', 'create', 'joiners:create'),
            'joiners-edit'      => $this->insertPermission('Joiners edit', 'joiners', 'edit', 'joiners:edit'),
            'joiners-delete'    => $this->insertPermission('Joiners delete', 'joiners', 'delete', 'joiners:delete'),
            'joiners-browse'    => $this->insertPermission('Joiners browse', 'joiners', 'browse', 'joiners:browse'),
            'builders-browse'   => $this->insertPermission('Browse Builder', 'builders', 'browse', 'builders:browse'),
            'builders-create'   => $this->insertPermission('Add Builder', 'builders', 'create', 'builders:create'),
            'builders-edit'     => $this->insertPermission('Edit Builder', 'builders', 'edit', 'builders:edit'),
            'builders-delete'   => $this->insertPermission('Delete Builder', 'builders', 'delete', 'builders:delete'),
            'browse-sites'      => $this->insertPermission('Browse Sites', 'sites', 'browse-site', 'sites:browse'),
            'add-sites'         => $this->insertPermission('Add Sites', 'sites', 'create', 'sites:create'),
            'edit-sites'        => $this->insertPermission('Edit Sites', 'sites', 'edit', 'sites:edit'),
            'delete-sites'      => $this->insertPermission('Delete Sites', 'sites', 'delete', 'sites:delete'),
            'browse-building'   => $this->insertPermission('Browse Building Types', 'building_types', 'browse', 'building_types:browse'),
            'add-building'      => $this->insertPermission('Add Building Types', 'building_types', 'create', 'building_types:create'),
            'edit-building'     => $this->insertPermission('Edit Building Types', 'building_types', 'edit', 'building_types:edit'),
            'delete-building'   => $this->insertPermission('Delete Building Types', 'building_types', 'delete', 'building_types:delete'),
            'browse-plots'      => $this->insertPermission('Browse Plots', 'plots', 'browse', 'building_types:browse'),
            'add-plots'         => $this->insertPermission('Add Plots', 'plots', 'create', 'building_types:create'),
            'edit-plots'        => $this->insertPermission('Edit Plots', 'plots', 'edit', 'building_types:edit'),
            'delete-plots'      => $this->insertPermission('Delete Plots', 'plots', 'delete', 'building_types:delete'),
            'browse-service-price' => $this->insertPermission('Browse Service Pricing', 'service_pricing', 'browse', 'service_pricing:browse'),
            'add-service-price' => $this->insertPermission('Add Service Pricing', 'service_pricing', 'create', 'service_pricing:create'),
            'browse-joiner-pricing' => $this->insertPermission('Browse Joiner Pricing', 'joiner_pricing', 'browse', 'joiner_pricing:browse'),
            'add-joiner-pricing'    => $this->insertPermission('Add Joiner Pricing', 'joiner_pricing', 'create', 'joiner_pricing:create'),
            'browse-services'       => $this->insertPermission('Browse Services', 'services', 'browse', 'services:browse'),
            'add-services'      => $this->insertPermission('Add Services', 'services', 'create', 'services:create'),
            'edit-services'     => $this->insertPermission('Edit Services', 'services', 'edit', 'services:edit'),
            'delete-services'   => $this->insertPermission('Delete Services', 'services', 'delete', 'services:delete'),
            'admin-jobs'        => $this->insertPermission('Admin Jobs', 'jobs', 'admin-jobs', 'admin:jobs'),
            'joiner-jobs'       => $this->insertPermission('Joiner Jobs', 'jobs', 'joiner-jobs', 'joiner:jobs'),
            'weekly-work'       => $this->insertPermission('Weekly Work', 'work', 'weekly-work', 'work:weekly'),
            'work-history'      => $this->insertPermission('My Work History', 'work', 'my-work-history', 'work:history'),
            'daily-work'        => $this->insertPermission('My Daily Work', 'work', 'daily-work', 'work:daily'),
            'wage-work'         => $this->insertPermission('Wage Work', 'work', 'wage-sheet', 'work:daily'),
            'weekly-work'       => $this->insertPermission('My Weekly Work', 'work', 'my-weekly-work', 'work:weekly'),
            'admin-reports'     => $this->insertPermission('Admin Reports', 'reports', 'reports', 'admin:reports'),
            'joiner-message'    => $this->insertPermission('Joiner message', 'message', 'message', 'message:message'),
            'joiner-notification' => $this->insertPermission('Joiner Notification', 'joinerNotification', 'joinerNotification', 'joinerNotification:joinerNotification'),
            'admin-notification' => $this->insertPermission('Admin notification', 'notification', 'notification', 'notification:notification'),
        ];

        $this->assignPermissionsToRole($map, 'admin');
        
        //
        // DB::table('permissions')->insert([
        //     /*  dashboards module */

        //     // Admin Dashboard
        //     [
        //         'id' => 50,
        //         'name' => 'Admin Dashboard',
        //         'module' => 'dashboard',
        //         'permission' => 'adminDashboard',
        //         'api_permission' => 'admin:dashboard',
        //     ],
        //     // Builder Dashboard
        //     [
        //         'id' => 51,
        //         'name' => 'Builder Dashboard',
        //         'module' => 'dashboard',
        //         'permission' => 'buildersDashboard',
        //         'api_permission' => 'builder:dashboard',
        //     ],
        //     // site Dashboard
        //     [
        //         'id' => 52,
        //         'name' => 'Site Dashboard',
        //         'module' => 'dashboard',
        //         'permission' => 'sitesDashboard',
        //         'api_permission' => 'site:dashboard',
        //     ],
        //     // JOiner Dashboard
        //     [
        //         'id' => 53,
        //         'name' => 'Joiner Dashboard',
        //         'module' => 'dashboard',
        //         'permission' => 'joinerDashboard',
        //         'api_permission' => 'joiner:dashboard',
        //     ],

        //     // Joiners module
        //     [
        //         'id' => 55,
        //         'name' => 'Joiners view',
        //         'module' => 'joiners',
        //         'permission' => 'view',
        //         'api_permission' => 'joiners:view',
        //     ],
        //     [
        //         'id' => 56,
        //         'name' => 'Joiners create',
        //         'module' => 'joiners',
        //         'permission' => 'create',
        //         'api_permission' => 'joiners:create',
        //     ],
        //     [
        //         'id' => 57,
        //         'name' => 'Joiners edit',
        //         'module' => 'joiners',
        //         'permission' => 'edit',
        //         'api_permission' => 'joiners:edit',
        //     ],
        //     [
        //         'id' => 58,
        //         'name' => 'Joiners delete',
        //         'module' => 'joiners',
        //         'permission' => 'delete',
        //         'api_permission' => 'joiners:delete',
        //     ],
        //     [
        //         'id' => 59,
        //         'name' => 'Joiners browse',
        //         'module' => 'joiners',
        //         'permission' => 'browse',
        //         'api_permission' => 'joiners:browse',
        //     ],

        //     // Builders module
        //     [
        //         'id' => 60,
        //         'name' => 'Browse Builder',
        //         'module' => 'builders',
        //         'permission' => 'browse',
        //         'api_permission' => 'builders:browse',
        //     ],
        //     [
        //         'id' => 61,
        //         'name' => 'Add Builder',
        //         'module' => 'builders',
        //         'permission' => 'create',
        //         'api_permission' => 'builders:create',
        //     ],
        //     [
        //         'id' => 62,
        //         'name' => 'Edit Builder',
        //         'module' => 'builders',
        //         'permission' => 'edit',
        //         'api_permission' => 'builders:edit',
        //     ],
        //     [
        //         'id' => 63,
        //         'name' => 'Delete Builder',
        //         'module' => 'builders',
        //         'permission' => 'delete',
        //         'api_permission' => 'builders:delete',
        //     ],

        //     // Sites Module module
        //     [
        //         'id' => 64,
        //         'name' => 'Browse Sites',
        //         'module' => 'sites',
        //         'permission' => 'browse-site',
        //         'api_permission' => 'sites:browse',
        //     ],
        //     [
        //         'id' => 65,
        //         'name' => 'Add Sites',
        //         'module' => 'sites',
        //         'permission' => 'create',
        //         'api_permission' => 'sites:create',
        //     ],
        //     [
        //         'id' => 66,
        //         'name' => 'Edit Sites',
        //         'module' => 'sites',
        //         'permission' => 'edit',
        //         'api_permission' => 'sites:edit',
        //     ],
        //     [
        //         'id' => 67,
        //         'name' => 'Delete Sites',
        //         'module' => 'sites',
        //         'permission' => 'delete',
        //         'api_permission' => 'sites:delete',
        //     ],
        //     // Building types module
        //     [
        //         'id' => 68,
        //         'name' => 'Browse Building Types',
        //         'module' => 'building_types',
        //         'permission' => 'browse',
        //         'api_permission' => 'building_types:browse',
        //     ],
        //     [
        //         'id' => 69,
        //         'name' => 'Add Building Types',
        //         'module' => 'building_types',
        //         'permission' => 'create',
        //         'api_permission' => 'building_types:create',
        //     ],
        //     [
        //         'id' => 70,
        //         'name' => 'Edit Building Types',
        //         'module' => 'building_types',
        //         'permission' => 'edit',
        //         'api_permission' => 'building_types:edit',
        //     ],
        //     [
        //         'id' => 71,
        //         'name' => 'Delete Building Types',
        //         'module' => 'building_types',
        //         'permission' => 'delete',
        //         'api_permission' => 'building_types:delete',
        //     ],
        //     // Plots module
        //     [
        //         'id' => 72,
        //         'name' => 'Browse Plots',
        //         'module' => 'plots',
        //         'permission' => 'browse',
        //         'api_permission' => 'building_types:browse',
        //     ],
        //     [
        //         'id' => 73,
        //         'name' => 'Add Plots',
        //         'module' => 'plots',
        //         'permission' => 'create',
        //         'api_permission' => 'building_types:create',
        //     ],
        //     [
        //         'id' => 74,
        //         'name' => 'Edit Plots',
        //         'module' => 'plots',
        //         'permission' => 'edit',
        //         'api_permission' => 'building_types:edit',
        //     ],
        //     [
        //         'id' => 75,
        //         'name' => 'Delete Plots',
        //         'module' => 'plots',
        //         'permission' => 'delete',
        //         'api_permission' => 'building_types:delete',
        //     ],

        //     // Service Pricings module
        //     [
        //         'id' => 76,
        //         'name' => 'Browse Service Pricing',
        //         'module' => 'service_pricing',
        //         'permission' => 'browse',
        //         'api_permission' => 'service_pricing:browse',
        //     ],
        //     [
        //         'id' => 77,
        //         'name' => 'Add Service Pricing',
        //         'module' => 'service_pricing',
        //         'permission' => 'create',
        //         'api_permission' => 'service_pricing:create',
        //     ],

        //     // joiners Pricings module
        //     [
        //         'id' => 78,
        //         'name' => 'Browse Joiner Pricing',
        //         'module' => 'joiner_pricing',
        //         'permission' => 'browse',
        //         'api_permission' => 'joiner_pricing:browse',
        //     ],
        //     [
        //         'id' => 79,
        //         'name' => 'Add Joiner Pricing',
        //         'module' => 'joiner_pricing',
        //         'permission' => 'create',
        //         'api_permission' => 'joiner_pricing:create',
        //     ],

        //     // Services module
        //     [
        //         'id' => 80,
        //         'name' => 'Browse Services',
        //         'module' => 'services',
        //         'permission' => 'browse',
        //         'api_permission' => 'services:browse',
        //     ],
        //     [
        //         'id' => 81,
        //         'name' => 'Add Services',
        //         'module' => 'services',
        //         'permission' => 'create',
        //         'api_permission' => 'services:create',
        //     ],
        //     [
        //         'id' => 82,
        //         'name' => 'Edit Services',
        //         'module' => 'services',
        //         'permission' => 'edit',
        //         'api_permission' => 'services:edit',
        //     ],
        //     [
        //         'id' => 83,
        //         'name' => 'Delete Services',
        //         'module' => 'services',
        //         'permission' => 'delete',
        //         'api_permission' => 'services:delete',
        //     ],

        //     [
        //         'id' => 86,
        //         'name' => 'Admin Jobs',
        //         'module' => 'jobs',
        //         'permission' => 'admin-jobs',
        //         'api_permission' => 'admin:jobs',
        //     ],
        //     [
        //         'id' => 111,
        //         'name' => 'Joiner Jobs',
        //         'module' => 'jobs',
        //         'permission' => 'joiner-jobs',
        //         'api_permission' => 'joiner:jobs',
        //     ],

        //     // work module
        //     [
        //         'id' => 90,
        //         'name' => 'Weekly Work',
        //         'module' => 'work',
        //         'permission' => 'weekly-work',
        //         'api_permission' => 'work:weekly',
        //     ],
        //     [
        //         'id' => 91,
        //         'name' => 'My Work History',
        //         'module' => 'work',
        //         'permission' => 'my-work-history',
        //         'api_permission' => 'work:history',
        //     ],
        //     [
        //         'id' => 92,
        //         'name' => 'My Daily Work',
        //         'module' => 'work',
        //         'permission' => 'my-daily-work',
        //         'api_permission' => 'mywork:daily',
        //     ],
        //     [
        //         'id' => 93,
        //         'name' => 'Daily Work',
        //         'module' => 'work',
        //         'permission' => 'daily-work',
        //         'api_permission' => 'work:daily',
        //     ],
        //     [
        //         'id' => 94,
        //         'name' => 'Wage Work',
        //         'module' => 'work',
        //         'permission' => 'wage-sheet',
        //         'api_permission' => 'work:daily',
        //     ],
        //     [
        //         'id' => 95,
        //         'name' => 'My Weekly Work',
        //         'module' => 'work',
        //         'permission' => 'my-weekly-work',
        //         'api_permission' => 'work:weekly',
        //     ],

        //     //            permission for admin reports
        //     [
        //         'id' => 150,
        //         'name' => 'Admin Reports',
        //         'module' => 'reports',
        //         'permission' => 'reports',
        //         'api_permission' => 'admin:reports',
        //     ],

        //     //            for joiner message
        //     [
        //         'id' => 151,
        //         'name' => 'Joiner message',
        //         'module' => 'message',
        //         'permission' => 'message',
        //         'api_permission' => 'message:message',
        //     ],
        //     [
        //         'id' => 153,
        //         'name' => 'Joiner Notification',
        //         'module' => 'joinerNotification',
        //         'permission' => 'joinerNotification',
        //         'api_permission' => 'joinerNotification:joinerNotification',
        //     ],
        //     //            for admin notifications
        //     [
        //         'id' => 152,
        //         'name' => 'Admin notification',
        //         'module' => 'notification',
        //         'permission' => 'notification',
        //         'api_permission' => 'notification:notification',
        //     ],

            /* permissions end here */
        // ]);
    }
}
