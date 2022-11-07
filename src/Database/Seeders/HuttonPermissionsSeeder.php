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
            'builders-browse' => $this->insertPermission(
                'Browse Builder',
                'builders',
                'browse',
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
            'browse-services' => $this->insertPermission(
                'Browse Services',
                'services',
                'browse',
                'services:browse'
            ),
            'add-services' => $this->insertPermission(
                'Add Services',
                'services',
                'create',
                'services:create'
            ),
            'edit-services' => $this->insertPermission(
                'Edit Services',
                'services',
                'edit',
                'services:edit'
            ),
            'delete-services' => $this->insertPermission(
                'Delete Services',
                'services',
                'delete',
                'services:delete'
            ),
            'admin-jobs' => $this->insertPermission(
                'Admin Jobs',
                'jobs',
                'admin-jobs',
                'admin:jobs'
            ),

            'weekly-work' => $this->insertPermission(
                'Weekly Work',
                'work',
                'weekly-work',
                'work:weekly'
            ),

            'wage-work' => $this->insertPermission(
                'Wage Work',
                'work',
                'wage-sheet',
                'work:daily'
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

        $this->assignPermissionsToRole($map, 'admin');

        $joinerMap = [
            'joiner-dashboard' => $this->insertPermission(
                'Joiner Dashboard',
                'dashboard',
                'joinerDashboard',
                'joiner:dashboard'
            ),
            'joiner-jobs' => $this->insertPermission(
                'Joiner Jobs',
                'jobs',
                'joiner-jobs',
                'joiner:jobs'
            ),
            'work-history' => $this->insertPermission(
                'My Work History',
                'work',
                'my-work-history',
                'work:history'
            ),

            'weekly-work' => $this->insertPermission(
                'My Weekly Work',
                'work',
                'my-weekly-work',
                'work:weekly'
            ),
            'joiner-message' => $this->insertPermission(
                'Joiner message',
                'message',
                'message',
                'message:message'
            ),
            'joiner-notification' => $this->insertPermission(
                'Joiner Notification',
                'joinerNotification',
                'joinerNotification',
                'joinerNotification:joinerNotification'
            ),
            'daily-work' => $this->insertPermission(
                'My Daily Work',
                'work',
                'daily-work',
                'work:daily'
            ),
        ];

        $this->assignPermissionsToRole($joinerMap, 'joiner');
    }
}
