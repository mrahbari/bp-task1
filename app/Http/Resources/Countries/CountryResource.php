<?php
/**
 * @author Mojtaba Rahbari <mojtaba.rahbari@gmail.com | mojtabarahbari.ir>
 * @copyright Copyright &copy; from 2022 Mojtaba.
 * @version 1.0.0
 * @date 2022/02/06 15:00 PM
 */

namespace App\Http\Resources\Countries;

use App\Base\Http\Resources\AbstractResource;

class CountryResource extends AbstractResource
{
    public function payload(): array
    {
        return [
            'id' => hashids_encode($this->id),
            'name' => $this->name,
            'iso2' => $this->iso2,
            'iso3' => $this->iso3,
            'created_at' => $this->created_at,
            ];// + (config('app.env') !== 'production' ? ['id_in_debug_mode' => $this->id] : []);
    }
}
