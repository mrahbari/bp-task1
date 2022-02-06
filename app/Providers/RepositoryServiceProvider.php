<?php
/**
 * App\Providers\RepositoryServiceProvider.php
 *
 * @author Mojtaba Rahbari <mojtaba.rahbari@gmail.com | mojtabarahbari.ir>
 * @copyright Copyright &copy; from 2022 Mojtaba.
 * @version 1.0.0
 * @date 2022/02/05 15:00 PM
 */

namespace App\Providers;

use App\Repositories\Countries\CountryRepository;
use App\Repositories\Countries\Interfaces\CountryRepositoryInterface;
use App\Repositories\Users\Interfaces\UserRepositoryInterface;
use App\Repositories\Users\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        /*$this->app->bind(
            UserDetailRepositoryInterface::class,
            UserDetailRepository::class
        ); */

        $this->app->bind(
            CountryRepositoryInterface::class,
            CountryRepository::class
        );

    }
}
