<?php
/**
 * @author Mojtaba Rahbari <mojtaba.rahbari@gmail.com | mojtabarahbari.ir>
 * @copyright Copyright &copy; from 2022 Mojtaba.
 * @version 1.0.0
 * @date 2022/02/06 15:00 PM
 */

namespace App\Models;

use App\Scopes\Users\UserScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use UserScopes;

    /**
     * @var string[]
     */
    protected $appends = [
        'has_details'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Retrieve country object via user detail entity.   $users --> $userDetails  --> $country
     *
     * @return HasOneThrough
     */
    public function countryThrough(): HasOneThrough
    {
        return $this->hasOneThrough(
            Country::class,
            UserDetail::class,
            'user_id',
            'id',
            'id',
            'citizenship_country_id'
        );
    }

    /**
     * Get user details
     *
     * @return HasOne
     */
    public function details(): HasOne
    {
        return $this->hasOne(UserDetail::class);
    }

    /**
     * Check whether model has user details or not
     *
     * @return bool
     */
    public function getHasDetailsAttribute(): bool
    {
        return (bool)$this->details;
    }

}
