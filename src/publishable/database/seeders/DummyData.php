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
        //        FOR GENERATING SERVICES
        for ($i = 1; $i <= 10; $i++) {
            Service::create([
                'service_name' => 'Service ' . $i,
                'description' => 'Lorem Ipsum dolor sit amit',
            ]);
        }

        //      FOR GENERATING SITES

        DB::table('sites')->insert([
            [
                'uuid' => (string) Str::uuid(),
                'customer_id' => 1,
                'site_name' => 'Abc Site',
                'slug' => Str::slug('Abc Site'),
                'street_1' => 'Main University Road',
                'street_2' => '',
                'city' => 'Karachi',
                'postcode' => '76500',
                'county' => 'Sindh',
                'telephone_number' => '+923001234567',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'customer_id' => 1,
                'site_name' => 'Def Site',
                'slug' => Str::slug('Def Site'),
                'street_1' => 'Main University Road',
                'street_2' => '',
                'city' => 'Karachi',
                'postcode' => '76500',
                'county' => 'Sindh',
                'telephone_number' => '+923001545845',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'customer_id' => 2,
                'site_name' => 'Xyz Site',
                'slug' => Str::slug('Xyz Site'),
                'street_1' => 'Main University Road',
                'street_2' => '',
                'city' => 'Karachi',
                'postcode' => '76500',
                'county' => 'Sindh',
                'telephone_number' => '+923001362501',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'customer_id' => 2,
                'site_name' => 'MMP Site',
                'slug' => Str::slug('MMP Site'),
                'street_1' => 'Main University Road',
                'street_2' => '',
                'city' => 'Karachi',
                'postcode' => '76500',
                'county' => 'Sindh',
                'telephone_number' => '+923001360001',
            ],
        ]);

        //      FOR GENERATING BUILDING TYPES
        DB::table('building_types')->insert([
            [
                'site_id' => 1,
                'building_type_name' => 'Building ABC',
            ],
            [
                'site_id' => 1,
                'building_type_name' => 'Building DEF',
            ],
            [
                'site_id' => 2,
                'building_type_name' => 'Building GHQ',
            ],
            [
                'site_id' => 2,
                'building_type_name' => 'Building XYZ',
            ],
            [
                'site_id' => 2,
                'building_type_name' => 'Building PPP',
            ],
        ]);

        //      FOR GENERATING PLOTS
        DB::table('plots')->insert([
            [
                'uuid' => (string) Str::uuid(),
                'building_type_id' => 1,
                'plot_name' => 'PL-001',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'building_type_id' => 1,
                'plot_name' => 'PL-002',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'building_type_id' => 1,
                'plot_name' => 'PL-003',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'building_type_id' => 1,
                'plot_name' => 'PL-004',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'building_type_id' => 1,
                'plot_name' => 'PL-005',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'building_type_id' => 2,
                'plot_name' => 'PL-006',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'building_type_id' => 2,
                'plot_name' => 'PL-007',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'building_type_id' => 2,
                'plot_name' => 'PL-008',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'building_type_id' => 2,
                'plot_name' => 'PL-009',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'building_type_id' => 2,
                'plot_name' => 'PL-010',
            ],
        ]);
    }
}
