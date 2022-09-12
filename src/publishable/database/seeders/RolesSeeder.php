n<?php namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Sty\Hutton\Models\Role;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RolesSeeder extends Seeder
{
    /*
     *
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('roles')->insert(
            [
                'id' => 4,
                'name' => 'huttonscope_admin',
            ],
            [
                'id' => 3,
                'name' => 'joiner',
            ]
        );
    }
}
