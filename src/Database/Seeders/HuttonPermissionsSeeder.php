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
        /* Admin Role Permissions */
        $map = [
            'admin-dashboard' => $this->insertPermission(
                'Admin Dashboard',
                'dashboard',
                'adminDashboard',
                'admin:dashboard'
            ),
            'builder-dashboard' => $this->insertPermission(
                'Builder Dashboard',
                'dashboard',
                'buildersDashboard',
                'builder:dashboard'
            ),
            'site-dashboard' => $this->insertPermission(
                'Site Dashboard',
                'dashboard',
                'buildersDashboard',
                'builder:dashboard'
            ),

            'joiners-view' => $this->insertPermission(
                'Joiners view',
                'joiners',
                'view',
                'joiners:view'
            ),
            'joiners-create' => $this->insertPermission(
                'Joiners create',
                'joiners',
                'create',
                'joiners:create'
            ),
            'joiners-edit' => $this->insertPermission(
                'Joiners edit',
                'joiners',
                'edit',
                'joiners:edit'
            ),
            'joiners-delete' => $this->insertPermission(
                'Joiners delete',
                'joiners',
                'delete',
                'joiners:delete'
            ),
            'joiners-browse' => $this->insertPermission(
                'Joiners browse',
                'joiners',
                'browse',
                'joiners:browse'
            ),
            'builders-view' => $this->insertPermission(
                'Browse Builder',
                'builders',
                'view',
                'builders:browse'
            ),
            'builders-create' => $this->insertPermission(
                'Add Builder',
                'builders',
                'create',
                'builders:create'
            ),
            'builders-edit' => $this->insertPermission(
                'Edit Builder',
                'builders',
                'edit',
                'builders:edit'
            ),
            'builders-delete' => $this->insertPermission(
                'Delete Builder',
                'builders',
                'delete',
                'builders:delete'
            ),
            'browse-sites' => $this->insertPermission(
                'Browse Sites',
                'sites',
                'browse-site',
                'sites:browse'
            ),
            'add-sites' => $this->insertPermission(
                'Add Sites',
                'sites',
                'create',
                'sites:create'
            ),
            'edit-sites' => $this->insertPermission(
                'Edit Sites',
                'sites',
                'edit',
                'sites:edit'
            ),
            'delete-sites' => $this->insertPermission(
                'Delete Sites',
                'sites',
                'delete',
                'sites:delete'
            ),
            'browse-building' => $this->insertPermission(
                'Browse Building Types',
                'building_types',
                'browse',
                'building_types:browse'
            ),
            'add-building' => $this->insertPermission(
                'Add Building Types',
                'building_types',
                'create',
                'building_types:create'
            ),
            'edit-building' => $this->insertPermission(
                'Edit Building Types',
                'building_types',
                'edit',
                'building_types:edit'
            ),
            'delete-building' => $this->insertPermission(
                'Delete Building Types',
                'building_types',
                'delete',
                'building_types:delete'
            ),
            'browse-plots' => $this->insertPermission(
                'Browse Plots',
                'plots',
                'browse',
                'building_types:browse'
            ),
            'add-plots' => $this->insertPermission(
                'Add Plots',
                'plots',
                'create',
                'building_types:create'
            ),
            'edit-plots' => $this->insertPermission(
                'Edit Plots',
                'plots',
                'edit',
                'building_types:edit'
            ),
            'delete-plots' => $this->insertPermission(
                'Delete Plots',
                'plots',
                'delete',
                'building_types:delete'
            ),
            'browse-service-price' => $this->insertPermission(
                'Browse Service Pricing',
                'service_pricing',
                'browse',
                'service_pricing:browse'
            ),
            'add-service-price' => $this->insertPermission(
                'Add Service Pricing',
                'service_pricing',
                'create',
                'service_pricing:create'
            ),
            'browse-joiner-pricing' => $this->insertPermission(
                'Browse Joiner Pricing',
                'joiner_pricing',
                'browse',
                'joiner_pricing:browse'
            ),
            'add-joiner-pricing' => $this->insertPermission(
                'Add Joiner Pricing',
                'joiner_pricing',
                'create',
                'joiner_pricing:create'
            ),
            'view-fixes' => $this->insertPermission(
                'Browse Fixes',
                'fixes',
                'view',
                'fixes:browse'
            ),
            'add-fixes' => $this->insertPermission(
                'Add fixes',
                'fixes',
                'create',
                'fixes:create'
            ),
            'edit-fixes' => $this->insertPermission(
                'Edit fixes',
                'fixes',
                'edit',
                'fixes:edit'
            ),
            'delete-fixes' => $this->insertPermission(
                'Delete fixes',
                'fixes',
                'delete',
                'fixes:delete'
            ),
            'admin-jobs' => $this->insertPermission(
                'Admin Jobs',
                'jobs',
                'admin-jobs',
                'admin:jobs'
            ),
            'hutton-jobs-view' => $this->insertPermission(
                'Hutton Jobs view',
                'hutton-jobs',
                'view',
                'hutton-jobs:view'
            ),
            'wage-sheet-view' => $this->insertPermission(
                'Wage Sheet View',
                'wage-sheet',
                'wage-sheet',
                'wagesheet:view'
            ),
            'admin-reports' => $this->insertPermission(
                'Admin Reports',
                'reports',
                'reports',
                'admin:reports'
            ),

            'admin-notification' => $this->insertPermission(
                'Admin notification',
                'notification',
                'notification',
                'notification:notification'
            ),
        ];

        /* Joiner Role Permissions */
        $joinerMap = [
            // 'hutton-joiner-jobs-view' => $this->insertPermission(
            //     'Hutton Joiner Jobs view',
            //     'hutton-joiner-jobs',
            //     'view',
            //     'hutton-joiner-jobs:view'
            // ),
            // 'joiner-weekly-work-view' => $this->insertPermission(
            //     'Joiner Weekly Work view',
            //     'joiner-weekly-work',
            //     'view',
            //     'joiner-weekly-work:view'
            // ),
            // 'joiner-daily-work-view' => $this->insertPermission(
            //     'My Daily Work view',
            //     'joiner-daily-work',
            //     'view',
            //     'joiner-daily-work:view'
            // ),
            // 'joiner-work-history-view' => $this->insertPermission(
            //     'Joiner Work History view',
            //     'joiner-work-history',
            //     'view',
            //     'joiner-work-history:view'
            // ),
            'view' => $this->insertPermission(
                'Joiner Jobs view',
                'joiner-jobs',
                'view'
            ),
            'daily-work-view' => $this->insertPermission(
                'My Daily Work view',
                'my-daily-work',
                'view'
            ),
            'weekly-work-view' => $this->insertPermission(
                'My Weekly Work view',
                'my-weekly-work',
                'view'
            ),
            'work-history-view' => $this->insertPermission(
                'My Work History view',
                'my-work-history',
                'view'
            ),
            // 'view' => $this->insertPermission('Joiner Jobs view', 'joiner-jobs', 'view'),
        ];

        /* SuperVisor Role Permissions */
        // $supervisorMap = [
        //     'admin-dashboard' => $this->insertPermission(
        //         'Admin Dashboard',
        //         'dashboard',
        //         'adminDashboard',
        //         'admin:dashboard'
        //     ),
        //     'builder-dashboard' => $this->insertPermission(
        //         'Builder Dashboard',
        //         'dashboard',
        //         'buildersDashboard',
        //         'builder:dashboard'
        //     ),
        //     'site-dashboard' => $this->insertPermission(
        //         'Site Dashboard',
        //         'dashboard',
        //         'buildersDashboard',
        //         'builder:dashboard'
        //     ),

        //     'joiners-view' => $this->insertPermission(
        //         'Joiners view',
        //         'joiners',
        //         'view',
        //         'joiners:view'
        //     ),
        //     'joiners-browse' => $this->insertPermission(
        //         'Joiners browse',
        //         'joiners',
        //         'browse',
        //         'joiners:browse'
        //     ),
        //     'builders-browse' => $this->insertPermission(
        //         'Browse Builder',
        //         'builders',
        //         'browse',
        //         'builders:browse'
        //     ),
        //     'browse-sites' => $this->insertPermission(
        //         'Browse Sites',
        //         'sites',
        //         'browse-site',
        //         'sites:browse'
        //     ),
        //     'browse-building' => $this->insertPermission(
        //         'Browse Building Types',
        //         'building_types',
        //         'browse',
        //         'building_types:browse'
        //     ),
        //     'browse-plots' => $this->insertPermission(
        //         'Browse Plots',
        //         'plots',
        //         'browse',
        //         'building_types:browse'
        //     ),
        //     'browse-service-price' => $this->insertPermission(
        //         'Browse Service Pricing',
        //         'service_pricing',
        //         'browse',
        //         'service_pricing:browse'
        //     ),
        //     'browse-joiner-pricing' => $this->insertPermission(
        //         'Browse Joiner Pricing',
        //         'joiner_pricing',
        //         'browse',
        //         'joiner_pricing:browse'
        //     ),
        //     'browse-services' => $this->insertPermission(
        //         'Browse Services',
        //         'services',
        //         'browse',
        //         'services:browse'
        //     ),
        //     'admin-jobs' => $this->insertPermission(
        //         'Admin Jobs',
        //         'jobs',
        //         'admin-jobs',
        //         'admin:jobs'
        //     ),
        //     'wage-work' => $this->insertPermission(
        //         'Wage Work',
        //         'work',
        //         'wage-sheet',
        //         'work:daily'
        //     ),
        //     'admin-reports' => $this->insertPermission(
        //         'Admin Reports',
        //         'reports',
        //         'reports',
        //         'admin:reports'
        //     ),
        // ];

        $this->assignPermissionsToRole($map, 'admin');

        $this->assignPermissionsToRole($joinerMap, 'joiner');

        // $this->assignPermissionsToRole($supervisorMap, 'supervisor');
    }
}
