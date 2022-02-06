<?php
/**
 * @author Mojtaba Rahbari <mojtaba.rahbari@gmail.com | mojtabarahbari.ir>
 * @copyright Copyright &copy; from 2022 Mojtaba.
 * @version 1.0.0
 * @date 2022/02/06 15:00 PM
 */

namespace App\Http\Resources\Users;

use App\Base\Http\Resources\AbstractResource;
use App\Http\Resources\Countries\CountryResource;
use App\Http\Resources\UserDetails\UserDetailResource;

class UserResource extends AbstractResource
{
    public function payload(): array
    {
        return [

            'id' => hashids_encode($this->id),
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'active' => trans_boolean($this->active),
            'created_at' => $this->created_at,
            'includes' => [
                'has_details' => $this->has_details,
                'details' => new UserDetailResource($this->details),
                'country' => new CountryResource($this->countryThrough),
            ]// + (config('app.env') !== 'production' ? ['id_in_debug_mode' => $this->id] : [])
        ];
    }
}
