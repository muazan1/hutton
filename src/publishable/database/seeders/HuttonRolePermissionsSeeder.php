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
            //admin Role   (permissionable_id === 1)
            [
                'permission_id' => 50,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 51,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 52,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 53,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 55,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 56,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 57,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 58,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 59,
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
            [
                'permission_id' => 64,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 65,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 66,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 67,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 68,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 69,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 70,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 71,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 72,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 73,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 74,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 75,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 76,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 77,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 78,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 79,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 80,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 81,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 82,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 83,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 85,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 86,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 90,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 91,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 92,
                'permissionable_id' => '1',
                'permissionable_type' => 'App\Models\Role',
            ],
            //  Joiner Role (permissionable id === 3)
            [
                'permission_id' => 53,
                'permissionable_id' => '3',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 85,
                'permissionable_id' => '3',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 86,
                'permissionable_id' => '3',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 90,
                'permissionable_id' => '3',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 92,
                'permissionable_id' => '3',
                'permissionable_type' => 'App\Models\Role',
            ],
            [
                'permission_id' => 93,
                'permissionable_id' => '3',
                'permissionable_type' => 'App\Models\Role',
            ],
        ]);
    }
}
