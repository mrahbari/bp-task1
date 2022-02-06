<?php
/**
 * @author Mojtaba Rahbari <mojtaba.rahbari@gmail.com | mojtabarahbari.ir>
 * @copyright Copyright &copy; from 2022 Mojtaba.
 * @version 1.0.0
 * @date 2022/02/06 15:00 PM
 */

namespace Tests\Unit\Countries;

use App\Exceptions\Countries\CountryInvalidArgumentException;
use App\Exceptions\Countries\CountryNotFoundException;
use App\Exceptions\UserDetails\UserDetailFoundException;
use App\Models\Country;
use App\Repositories\Countries\CountryRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CountryUnitTest extends TestCase
{
    use WithFaker;

    /**
     * country can be created by faker
     */
    public function test_it_can_create_the_country()
    {
        $countryISOAlpha3 = $this->faker->unique()->countryISOAlpha3();
        $data = [
            "name" => $this->faker->unique()->country() . '[' . $countryISOAlpha3 . ']',
            "iso2" => substr($countryISOAlpha3, 0, 2),
            "iso3" => $countryISOAlpha3,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $countryRepo = new CountryRepository(new Country);
        $country = $countryRepo->createCountry($data);

        $this->assertNotNull($country);
        $this->assertNotEmpty($country->name);
        $this->assertNotEmpty($country->iso2);
        $this->assertNotEmpty($country->iso3);
    }

    /**
     * Raise error during updating
     *
     * @throws CountryNotFoundException
     */
    public function test_fire_errors_when_updating_the_country()
    {
        $country = Country::factory()->create();
        $this->expectException(CountryInvalidArgumentException::class);

        $countryRepo = new CountryRepository($country);
        $countryRepo->updateCountry(['name' => null]);
    }

    /**
     * Country updating is possible with valid params
     *
     * @throws CountryNotFoundException
     */
    public function test_it_can_update_the_country()
    {
        $country = Country::factory()->create();
        $countryRepo = new CountryRepository($country);

        $update = ['name' => 'Iran'];
        $countryRepo->updateCountry($update);

        $this->assertEquals('Iran', $country->name);
    }

    /**
     * Raise error when country id is invalid
     *
     * @throws CountryNotFoundException
     */
    public function test_fire_errors_when_the_country_is_not_found()
    {
        $this->expectException(CountryNotFoundException::class);
        $countryRepo = new CountryRepository(new Country);
        $countryRepo->findCountryById(999);
    }

    /**
     * Find one country
     *
     * @throws CountryNotFoundException
     */
    public function test_it_can_find_the_country()
    {
        $country = Country::factory()->create();
        $countryRepo = new CountryRepository($country);
        $found = $countryRepo->findCountryById($country->id);
        $this->assertEquals($country->name, $found->name);
    }

    /**
     * Get all countries
     */
    public function test_it_can_list_all_countries()
    {
        $country = Country::factory()->create();
        $countryRepo = new CountryRepository($country);
        $count = $countryRepo->countCountries();    //7

        $this->assertCount($count, $countryRepo->listCountries());
    }
}
