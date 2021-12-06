<?php

use Illuminate\Database\Seeder;
use Newpixel\GeographyCRUD\App\Models\Continent;

class GeographyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('geo_touristic_zones')->delete();
        DB::table('geo_cities')->delete();
        DB::table('geo_countries')->delete();
        DB::table('geo_continents')->delete();

        //** Continents seeder */
        $continents = [
            ['name' => 'Africa', 'feature_image' => null],
            ['name' => 'America de Nord', 'feature_image' => null],
            ['name' => 'America de Sud', 'feature_image' => null],
            ['name' => 'Asia', 'feature_image' => null],
            ['name' => 'Australia', 'feature_image' => null],
            ['name' => 'Europa', 'feature_image' => null],
        ];

        foreach ($continents as $conti) {
            Continent::create([
                'name' => $conti['name'],
                'feature_image' => $conti['feature_image'],
            ]);
        }

        //** Countries seeder */

        $countries = [
            ['name' => 'Romania', 'code' => 'RO', 'continent' => 6],
            // ['name' => 'Bulgaria', 'code' => 'BG', 'continent' => 6],
        ];

        // $countries = DB::connection('mysql_old')->table('tari')->get();
        foreach ($countries as $country) {
            // DB::connection('mysql')->table('geo_countries')->insert([
            //     'id'               => $country->id,
            //     'name'             => $country->nume,
            //     'continent_id'     => 1,
            //     'full_details'          => $country->descriere,
            //     'image'            => null,
            //     'active'           => true,
            //     'show_on_homepage' => false,
            //     'created_at'       => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            //     'updated_at'       => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            //     'slug'             => $country->LinkSeo,
            // ]);

            DB::table('geo_countries')->insert(
                [
                    'name'             => $country['name'],
                    'continent_id'     => $country['continent'],
                    'full_details'     => null,
                    'operator_code'    => $country['code'],
                    'feature_image'    => null,
                    'active'           => true,
                    'show_on_homepage' => false,
                    'created_at'       => now()->format('Y-m-d H:i:s'),
                    'updated_at'       => now()->format('Y-m-d H:i:s'),
                    'slug'             => str_slug($country['name']),
                ]
            );
        }

        //** Touristic zones seeder */
        $zones = [
            ['id'=> 1, 'name' => 'Litoral', 'full_details' => null, 'slug'=>'litoral'],
            ['id'=> 3, 'name' => 'Munte', 'full_details' => null, 'slug'=>'munte'],
            ['id'=> 4, 'name' => 'Balneo', 'full_details' => null, 'slug'=>'balneo'],
            ['id'=> 5, 'name' => 'Delta', 'full_details' =>null, 'slug'=>'delta'],
            ['id'=> 6, 'name' => 'Oras', 'full_details' => null, 'slug'=>'oras'],
        ];

        // $zones = DB::connection('mysql_old')->table('tip_zonaTuristice')->get();

        foreach ($zones as $zone) {
            DB::table('geo_touristic_zones')->insert([
                'id'           => $zone['id'],
                'name'         => $zone['name'],
                'full_details' => $zone['full_details'],
                'active'       => true,
                'created_at'   => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'slug'         => $zone['slug'],
            ]);
        }

        //** Cities seeder */
    }
}
