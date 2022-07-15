<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Sty\Hutton\Models\{Customer, Plot, Site, BuildingType, Service};

class DummyData extends Seeder
{
    /*
     *
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {
            Customer::create([
                'uuid' => (string) Str::uuid(),
                'customer_name' => 'Customer ' . $i,

                'slug' => Str::slug('Customer ' . $i),
                'email' => 'customer' . $i . '@gmail.com',
                'street_1' => 'Main University Road',
                'street_2' => '',
                'city' => 'Karachi',
                'postcode' => '7650' . $i,
                'telephone_number' => '+92312021021' . $i,
                'county' => 'Sindh',
            ]);

            Service::create([
                'service_name' => 'Service ' . $i,
                'description' => 'Lorem Ipsum dolor sit amit',
            ]);

            Site::create([
                'uuid' => (string) Str::uuid(),
                'customer_id' => $i,
                'site_name' => 'Site ' . $i,
                'slug' => Str::slug('Site ' . $i),
                'street_1' => 'Main University Road',
                'street_2' => '',
                'city' => 'Karachi',
                'postcode' => '76500',
                'county' => 'Sindh',
                'telephone_number' => '+9231202102' . $i . '0',
            ]);

            Plot::create([
                'building_type_id' => $i,
                'plot_name' => 'PL-00' . $i,
            ]);

            BuildingType::create([
                'site_id' => $i,
                'building_type_name' => 'Building ' . $i,
            ]);
        }
    }
}
