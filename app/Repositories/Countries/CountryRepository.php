<?php
/**
 * @author Mojtaba Rahbari <mojtaba.rahbari@gmail.com | mojtabarahbari.ir>
 * @copyright Copyright &copy; from 2022 Mojtaba.
 * @version 1.0.0
 * @date 2022/02/06 15:00 PM
 */

namespace App\Repositories\Countries;

use App\Base\Repositories\BaseRepository;
use App\Exceptions\Countries\CountryInvalidArgumentException;
use App\Exceptions\Countries\CountryNotFoundException;
use App\Models\Country;
use App\Repositories\Countries\Interfaces\CountryRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class CountryRepository extends BaseRepository implements CountryRepositoryInterface
{
    /**
     * CountryRepository constructor.
     * @param Country $country
     */
    public function __construct(Country $country)
    {
        parent::__construct($country);
        $this->model = $country;
    }

    /**
     * List all the countries
     *
     * @param string $order
     * @param string $sort
     * @return Collection
     */
    public function listCountries(string $order = 'id', string $sort = 'desc'): Collection
    {
        return $this->model->query()->orderBy($order, $sort)->get();
    }

    /**
     * Return country  count based on params
     * @return int|null
     */
    public function countCountries(): ?int
    {
        return $this->model->query()->count();
    }

    /**
     * @param array $params
     * @return Country
     */
    public function createCountry(array $params): Country
    {
        return $this->create($params);
    }

    /**
     * Update the country
     *
     * @param array $params
     * @return Country
     * @throws CountryNotFoundException
     */
    public function updateCountry(array $params): Country
    {
        try {
            $this->model->update($params);
            return $this->findCountryById($this->model->id);
        } catch (QueryException $e) {
            throw new CountryInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Find the country
     *
     * @param string $id
     * @return Country
     * @throws CountryNotFoundException
     */
    public function findCountryById(string $id): Country
    {
        try {
            $id = hashids_decode($id);
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CountryNotFoundException('Country not found.');
        }
    }
}
