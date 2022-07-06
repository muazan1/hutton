<?php

use Illuminate\Database\Seeder;
use Sty\Hutton\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // for Creating Master Admin
        Role::create([
            'name' => 'Admin',
        ]);

        Role::create([
            'name' => 'Joiner',
        ]);
    }
}
