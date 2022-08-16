<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HuttonRolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('permissionables')->insert([
            //admin Role   (permissionable_id = 1)
            [
                'permission_id' => 37,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ], //joiner view
            [
                'permission_id' => 38,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ], // ..      create
            [
                'permission_id' => 39,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ], // ..      edit
            [
                'permission_id' => 40,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 41,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 55,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 47,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 48,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 49,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 60,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 61,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 62,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 63,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],

            // Joiner Role (permissionable id  === 3)
            [
                'permission_id' => 42,
                'permissionable_id' => '3',
                'permissionable_type' => 'App\Models\Role',
            ],

            [
                'permission_id' => 50,
                'permissionable_id' => '3',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 51,
                'permissionable_id' => '3',
                'permissionable_type' => 'App\Models\Role',
            ],

            [
                'permission_id' => 52,
                'permissionable_id' => '3',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 53,
                'permissionable_id' => '3',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 54,
                'permissionable_id' => '3',
                'permissionable_type' => 'App\Models\Role',
            ],
        ]);
    }
}
