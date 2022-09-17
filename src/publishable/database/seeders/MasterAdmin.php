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
            'first_name' => 'Master',
            'last_name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '+923001234567',
            'password' => Hash::make('password'),
            'address' => 'Jump Street',
        ]);

        User::create([
            'role_id' => 3,
            'uuid' => (string) Str::uuid(),
            'first_name' => 'Martin',
            'last_name' => 'Borrote',
            'email' => 'martin@admin.com',
            'phone' => '+923001234110',
            'password' => Hash::make('password'),
            'address' => 'Jump Street',
        ]);

        User::create([
            'role_id' => 3,
            'uuid' => (string) Str::uuid(),
            'first_name' => 'Salvador',
            'last_name' => 'Stephen',
            'email' => 'salvador@admin.com',
            'phone' => '+923001234220',
            'password' => Hash::make('password'),
            'address' => 'Jump Street',
        ]);

        User::create([
            'role_id' => 3,
            'uuid' => (string) Str::uuid(),
            'first_name' => 'Alex',
            'last_name' => 'James',
            'email' => 'alex@admin.com',
            'phone' => '+923001234230',
            'password' => Hash::make('password'),
            'address' => 'Jump Street',
        ]);

    }
}
