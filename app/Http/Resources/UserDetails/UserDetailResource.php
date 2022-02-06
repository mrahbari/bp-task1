<?php
/**
 * @author Mojtaba Rahbari <mojtaba.rahbari@gmail.com | mojtabarahbari.ir>
 * @copyright Copyright &copy; from 2022 Mojtaba.
 * @version 1.0.0
 * @date 2022/02/06 15:00 PM
 */

namespace App\Http\Resources\UserDetails;

use App\Base\Http\Resources\AbstractResource;

class UserDetailResource extends AbstractResource
{
    public function payload(): array
    {
        return [
            'id' => hashids_encode($this->id),
            'user_id' => hashids_encode($this->user_id),
            'citizenship_country_id' => hashids_encode($this->citizenship_country_id),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone_number' => $this->phone_number,
            'created_at' => $this->created_at,
            /*'includes' => [
                'country' => new CountryResource($this->country),
            ]*/
        ];// + (config('app.env') !== 'production' ? ['id_in_debug_mode' => $this->id, 'citizenship_country_id_in_debug_mode' => $this->citizenship_country_id] : []);
    }
}
