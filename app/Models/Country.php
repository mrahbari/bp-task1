<?php
/**
 * @author Mojtaba Rahbari <mojtaba.rahbari@gmail.com | mojtabarahbari.ir>
 * @copyright Copyright &copy; from 2022 Mojtaba.
 * @version 1.0.0
 * @date 2022/02/06 15:00 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'iso2',
        'iso3',
    ];


    /**
     * @return HasMany
     */
    public function userDetails(): HasMany
    {
        return $this->hasMany(UserDetail::class, 'citizenship_country_id');
    }

    /**
     * Retrieve country object via user detail entity.   $country --> $userDetails  --> $users
     *
     */
    /**
     * @return HasManyThrough
     */
    public function userThrough(): HasManyThrough
    {
        return $this->HasManyThrough(
            User::class,
            UserDetail::class,
            'citizenship_country_id',
            'id',
            'id',
            'user_id'
        );
    }

}
