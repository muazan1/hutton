<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Sty\Hutton\Models\{Customer, JoinerPricing, Plot, ServicePricing, Site, BuildingType, Service};

class DummyData extends Seeder
{
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
                'uuid' => (string) Str::uuid(),
                'site_id' => 1,
                'building_type_name' => 'Building ABC',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'site_id' => 1,
                'building_type_name' => 'Building DEF',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'site_id' => 2,
                'building_type_name' => 'Building GHQ',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'site_id' => 2,
                'building_type_name' => 'Building XYZ',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'site_id' => 2,
                'building_type_name' => 'Building PPP',
            ],
        ]);

        //      FOR GENERATING PLOTS
        DB::table('plots')->insert([
            [
                'building_type_id' => 1,
                'plot_name' => 'PL-001',
            ],
            [
                'building_type_id' => 1,
                'plot_name' => 'PL-002',
            ],
            ['building_type_id' => 1, 'plot_name' => 'PL-003'],
            ['building_type_id' => 1, 'plot_name' => 'PL-004'],
            ['building_type_id' => 1, 'plot_name' => 'PL-005'],
            ['building_type_id' => 2, 'plot_name' => 'PL-006'],
            ['building_type_id' => 2, 'plot_name' => 'PL-007'],
            ['building_type_id' => 2, 'plot_name' => 'PL-008'],
            ['building_type_id' => 2, 'plot_name' => 'PL-009'],
            ['building_type_id' => 2, 'plot_name' => 'PL-010'],
        ]);

//        for generating joiners

        User::create([
            'role_id' => 3,
            'uuid' => (string) Str::uuid(),
            'first_name' => 'Johnny',
            'last_name' => 'Parker',
            'email' => 'johnny@admin.com',
            'phone' => '+923001234000',
            'password' => Hash::make('password'),
            'address' => 'Jump Street',
        ]);

//        for joiner pricings

        $services = Service::all();

        $builders = User::where('role_id',2)->get();

        $buildingTypes = BuildingType::all();

        foreach($services as $service) {

            foreach ($builders as $builder)
            {
                JoinerPricing::create(
                    [
                        'builder_id'    => $builder->id,
                        'service_id'    => $service->id,
                        'price'        => rand(50,500)
                    ]
                );
            }

            foreach ($buildingTypes as $buildingType) {
                ServicePricing::create(
                    [
                        'building_type_id'    => $buildingType->id,
                        'service_id'     => $service->id,
                        'price' => rand(50,500)
                    ]
                );
            }

        }

    }
}
