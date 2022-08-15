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
            // Customer
            [
                'id' => 1,
                'name' => 'Customer view',
                'module' => 'customers',
                'permission' => 'view',
                'api_permission' => 'customer:view',
            ],
            [
                'id' => 2,
                'name' => 'Customer edit',
                'module' => 'customers',
                'permission' => 'edit',
                'api_permission' => 'customer:edit',
            ],
            [
                'id' => 3,
                'name' => 'Customer add',
                'module' => 'customers',
                'permission' => 'add',
                'api_permission' => 'customer:add',
            ],
            [
                'id' => 4,
                'name' => 'Customer delete',
                'module' => 'customers',
                'permission' => 'delete',
                'api_permission' => 'customer:delete',
            ],

            // Notes permissions
            [
                'id' => 5,
                'name' => 'Notes view',
                'module' => 'notes',
                'permission' => 'view',
                'api_permission' => 'notes:view',
            ],
            [
                'id' => 6,
                'name' => 'Notes edit',
                'module' => 'notes',
                'permission' => 'edit',
                'api_permission' => 'notes:edit',
            ],
            [
                'id' => 7,
                'name' => 'Notes add',
                'module' => 'notes',
                'permission' => 'add',
                'api_permission' => 'notes:add',
            ],
            [
                'id' => 8,
                'name' => 'Notes delete',
                'module' => 'notes',
                'permission' => 'delete',
                'api_permission' => 'notes:delete',
            ],

            // Tasks permissions
            [
                'id' => 9,
                'name' => 'Tasks view',
                'module' => 'tasks',
                'permission' => 'view',
                'api_permission' => 'tasks:view',
            ],
            [
                'id' => 10,
                'name' => 'Tasks edit',
                'module' => 'tasks',
                'permission' => 'edit',
                'api_permission' => 'tasks:edit',
            ],
            [
                'id' => 11,
                'name' => 'Tasks add',
                'module' => 'tasks',
                'permission' => 'add',
                'api_permission' => 'tasks:add',
            ],
            [
                'id' => 12,
                'name' => 'Tasks delete',
                'module' => 'tasks',
                'permission' => 'delete',
                'api_permission' => 'tasks:delete',
            ],

            // Services permissions
            [
                'id' => 13,
                'name' => 'Services view',
                'module' => 'services',
                'permission' => 'view',
                'api_permission' => 'services:view',
            ],
            [
                'id' => 14,
                'name' => 'Services edit',
                'module' => 'services',
                'permission' => 'edit',
                'api_permission' => 'services:edit',
            ],
            [
                'id' => 15,
                'name' => 'Services add',
                'module' => 'services',
                'permission' => 'add',
                'api_permission' => 'services:add',
            ],
            [
                'id' => 16,
                'name' => 'Services delete',
                'module' => 'services',
                'permission' => 'delete',
                'api_permission' => 'services:delete',
            ],

            // Projects permissions
            [
                'id' => 17,
                'name' => 'Projects view',
                'module' => 'projects',
                'permission' => 'view',
                'api_permission' => 'projects:view',
            ],
            [
                'id' => 18,
                'name' => 'Projects edit',
                'module' => 'projects',
                'permission' => 'edit',
                'api_permission' => 'projects:edit',
            ],
            [
                'id' => 19,
                'name' => 'Projects add',
                'module' => 'projects',
                'permission' => 'add',
                'api_permission' => 'projects:add',
            ],
            [
                'id' => 20,
                'name' => 'Projects delete',
                'module' => 'projects',
                'permission' => 'delete',
                'api_permission' => 'projects:delete',
            ],

            // Suppliers permissions
            [
                'id' => 21,
                'name' => 'Suppliers view',
                'module' => 'suppliers',
                'permission' => 'view',
                'api_permission' => 'suppliers:view',
            ],
            [
                'id' => 22,
                'name' => 'Suppliers edit',
                'module' => 'suppliers',
                'permission' => 'edit',
                'api_permission' => 'suppliers:edit',
            ],
            [
                'id' => 23,
                'name' => 'Suppliers add',
                'module' => 'suppliers',
                'permission' => 'add',
                'api_permission' => 'suppliers:add',
            ],
            [
                'id' => 24,
                'name' => 'Suppliers delete',
                'module' => 'suppliers',
                'permission' => 'delete',
                'api_permission' => 'suppliers:delete',
            ],

            // Departments permissions
            [
                'id' => 25,
                'name' => 'Departments view',
                'module' => 'departments',
                'permission' => 'view',
                'api_permission' => 'departments:view',
            ],
            [
                'id' => 26,
                'name' => 'Departments edit',
                'module' => 'departments',
                'permission' => 'edit',
                'api_permission' => 'departments:edit',
            ],
            [
                'id' => 27,
                'name' => 'Departments add',
                'module' => 'departments',
                'permission' => 'add',
                'api_permission' => 'departments:add',
            ],
            [
                'id' => 28,
                'name' => 'Departments delete',
                'module' => 'departments',
                'permission' => 'delete',
                'api_permission' => 'departments:delete',
            ],

            // Assets permissions
            [
                'id' => 29,
                'name' => 'Assets view',
                'module' => 'assets',
                'permission' => 'view',
                'api_permission' => 'assets:view',
            ],
            [
                'id' => 30,
                'name' => 'Assets edit',
                'module' => 'assets',
                'permission' => 'edit',
                'api_permission' => 'assets:edit',
            ],
            [
                'id' => 31,
                'name' => 'Assets add',
                'module' => 'assets',
                'permission' => 'add',
                'api_permission' => 'assets:add',
            ],
            [
                'id' => 32,
                'name' => 'Assets delete',
                'module' => 'assets',
                'permission' => 'delete',
                'api_permission' => 'assets:delete',
            ],

            // TextMarket permissions
            [
                'id' => 33,
                'name' => 'Textmarket view',
                'module' => 'textmarket',
                'permission' => 'view',
                'api_permission' => 'textmarket:view',
            ],
            [
                'id' => 34,
                'name' => 'Textmarket edit',
                'module' => 'textmarket',
                'permission' => 'edit',
                'api_permission' => 'textmarket:edit',
            ],
            [
                'id' => 35,
                'name' => 'Textmarket add',
                'module' => 'textmarket',
                'permission' => 'add',
                'api_permission' => 'textmarket:add',
            ],
            [
                'id' => 36,
                'name' => 'Textmarket delete',
                'module' => 'textmarket',
                'permission' => 'delete',
                'api_permission' => 'textmarket:delete',
            ],
        ]);
    }
}
