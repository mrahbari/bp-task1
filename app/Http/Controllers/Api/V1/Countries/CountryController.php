<?php
/**
 * @author Mojtaba Rahbari <mojtaba.rahbari@gmail.com | mojtabarahbari.ir>
 * @copyright Copyright &copy; from 2022 Mojtaba.
 * @version 1.0.0
 * @date 2022/02/06 15:00 PM
 */

namespace App\Http\Controllers\Api\V1\Countries;

use App\Base\Http\Controllers\BaseApiController;
use App\Http\Requests\Countries\CountryRequest;
use App\Http\Resources\Countries\CountryCollection;
use App\Http\Resources\Countries\CountryResource;
use App\Repositories\Countries\Interfaces\CountryRepositoryInterface;

class CountryController extends BaseApiController
{
    /**
     * CountryController constructor.
     */
    public function __construct(CountryRepositoryInterface $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    /**
     * Returns a listing of countries.
     *
     * @param CountryRequest $request
     * @return CountryCollection
     */
    public function index(CountryRequest $request): CountryCollection
    {
        $countries = $this->repository->listCountries();

        return new CountryCollection($countries);
    }

    /**
     * Returns a listing of countries.
     *
     * @param CountryRequest $request
     * @param $id
     * @return CountryResource
     */
    public function show(CountryRequest $request, $id): CountryResource
    {
        $country = $this->repository->findCountryById($id);
        return new CountryResource($country);
    }
}
