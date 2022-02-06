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

class UserDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_details')->insert(
            [
                [
                    "user_id" => 1,
                    "citizenship_country_id" => 1,
                    "first_name" => "Alex",
                    "last_name" => "Petro",
                    "phone_number" => "0043664111111"
                ],
                [
                    "user_id" => 4,
                    "citizenship_country_id" => 1,
                    "first_name" => "Dominik",
                    "last_name" => "Allan",
                    "phone_number" => "00436644444444"
                ],
                [
                    "user_id" => 5,
                    "citizenship_country_id" => 3,
                    "first_name" => "Andreas",
                    "last_name" => "Snow",
                    "phone_number" => "004366455555555"
                ],
                [
                    "user_id" => 7,
                    "citizenship_country_id" => 5,
                    "first_name" => "Igor",
                    "last_name" => "Snow",
                    "phone_number" => "0043664777777"
                ],
                [
                    "user_id" => 6,
                    "citizenship_country_id" => 1,
                    "first_name" => "Max",
                    "last_name" => "Mastermind",
                    "phone_number" => "00436646666666"
                ]
            ]);
    }
}
