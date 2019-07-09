<?php

use App\Models\Continent;
use App\Models\Country;
use Illuminate\Database\Seeder;

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
            ['name' => 'Africa', 'image' => null],
            ['name' => 'America de Nord', 'image' => null],
            ['name' => 'America de Sud', 'image' => null],
            ['name' => 'Asia', 'image' => null],
            ['name' => 'Australia', 'image' => null],
            ['name' => 'Europa', 'image' => null],
        ];

        foreach ($continents as $conti) {
            Continent::create([
                'name' => $conti['name'],
                'image' => $conti['image']
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
            //     'details'          => $country->descriere,
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
                    'details'          => null,
                    'operator_code'    => $country['code'],
                    'image'            => null,
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
            ['id'=> 1, 'name' => 'Litoral', 'details' => null, 'slug'=>'litoral'],
            ['id'=> 3, 'name' => 'Munte', 'details' => null, 'slug'=>'munte'],
            ['id'=> 4, 'name' => 'Balneo', 'details' => null, 'slug'=>'balneo'],
            ['id'=> 5, 'name' => 'Delta', 'details' =>null, 'slug'=>'delta'],
            ['id'=> 6, 'name' => 'Oras', 'details' => null, 'slug'=>'oras'],
        ];

        // $zones = DB::connection('mysql_old')->table('tip_zonaTuristice')->get();

        foreach ($zones as $zone) {
            DB::table('geo_touristic_zones')->insert([
                'id'         => $zone['id'],
                'name'       => $zone['name'],
                'details'    => $zone['details'],
                'active'     => true,
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'slug'       => $zone['slug']
            ]);
        }

        //** Cities seeder */
        // $cities = DB::connection('mysql_old')->table('orase')->get();

        // foreach ($cities as $city) {
        //     $exists = Storage::disk('public')->exists('oldimg/statiuni/st_'.$city->imagine);

        //     // daca exista imaginea, o mut in folderul item-ului corespunzator
        //     if ($exists) {
        //         //  $folder = \Storage::disk('public')->put("articles/" . $item->id');
        //         Storage::disk('public')->move('oldimg/statiuni/st_'.$city->imagine, 'cities/st_' . $city->imagine);
        //     }

        //     DB::connection('mysql')->table('geo_cities')->insert([
        //         'id'                => $city->id,
        //         'name'              => $city->nume,
        //         'touristic_zone_id' => $city->zona_turistica_id,
        //         'country_id'        => $city->tara_id,
        //         'short_info'        => $city->descriereMica,
        //         'details'           => $city->descriere,
        //         'image'             => 'cities/st_'.$city->imagine,
        //         'active'            => true,
        //         'created_at'        => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        //         'updated_at'        => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        //         'slug'              => $city->LinkSeo,
        //         'lft'               => $city->ord,
        //     ]);
        // }
    }
}
