<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Sty\Hutton\Models\Role;
use App\Models\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MasterAdmin extends Seeder
{
    /*
     *
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        User::create([
            'role_id' => 1,
            'uuid' => (string) Str::uuid(),
            'name' => 'Master Admin',
            'email' => 'admin@admin.com',
            'phone' => '+923001234567',
            'password' => Hash::make('password123'),
            'address' => 'Jump Street',
        ]);
    }
}
