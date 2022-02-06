<?php
/**
 * @author Mojtaba Rahbari <mojtaba.rahbari@gmail.com | mojtabarahbari.ir>
 * @copyright Copyright &copy; from 2022 Mojtaba.
 * @version 1.0.0
 * @date 2022/02/06 15:00 PM
 */

namespace App\Repositories\Countries\Interfaces;

use App\Base\Repositories\BaseRepositoryInterface;
use App\Models\Country;
use Illuminate\Support\Collection;

interface CountryRepositoryInterface extends BaseRepositoryInterface
{
    public function updateCountry(array $params): Country;

    public function listCountries(string $order = 'id', string $sort = 'desc'): Collection;

    public function createCountry(array $params): Country;

    public function findCountryById(string $id): Country;
}
