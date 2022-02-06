<?php
/**
 * @author Mojtaba Rahbari <mojtaba.rahbari@gmail.com | mojtabarahbari.ir>
 * @copyright Copyright &copy; from 2022 Mojtaba.
 * @version 1.0.0
 * @date 2022/02/06 15:00 PM
 */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $countryISOAlpha3 = $this->faker->unique()->countryISOAlpha3();
        return [
            "name" => $this->faker->unique()->country() . '['.$countryISOAlpha3.']',
            "iso2" => substr($countryISOAlpha3, 0, 2),
            "iso3" => $countryISOAlpha3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
