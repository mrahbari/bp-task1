<?php
/**
 * @author Mojtaba Rahbari <mojtaba.rahbari@gmail.com | mojtabarahbari.ir>
 * @copyright Copyright &copy; from 2022 Mojtaba.
 * @version 1.0.0
 * @date 2022/02/06 15:00 PM
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert(
            [
                [
                    //"id" => 1,
                    "name" => "Austria",
                    "iso2" => "AT",
                    "iso3" => "AUT",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    //"id" => 2,
                    "name" => "France",
                    "iso2" => "FR",
                    "iso3" => "FRA",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    //"id" => 3,
                    "name" => "Germany",
                    "iso2" => "DE",
                    "iso3" => "DEU",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    //"id" => 4,
                    "name" => "Spain",
                    "iso2" => "ES",
                    "iso3" => "ESP",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    //"id" => 5,
                    "name" => "Russian Federation",
                    "iso2" => "RU",
                    "iso3" => "RUS",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    //"id" => 6,
                    "name" => "China",
                    "iso2" => "CN",
                    "iso3" => "CHN",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]
        );
    }
}
