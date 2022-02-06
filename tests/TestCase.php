<?php

namespace Tests;

use App\Models\User;
use App\Repositories\Users\UserRepository;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    //use RefreshDatabase;

    private bool $withSeedData = true;
    private bool $doFresh = true;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('optimize:clear');
        if ($this->doFresh) {
            $this->artisan('migrate:fresh');
            //$this->artisan('migrate:refresh');
        }

        if ($this->withSeedData) {
            $this->artisan('db:seed', ['--class' => 'UserSeeder']);
            $this->artisan('db:seed', ['--class' => 'CountrySeeder']);
            $this->artisan('db:seed', ['--class' => 'UserDetailSeeder']);
        }
    }


    /**
     * Get users to handle test method requirements
     *
     * @param array $params
     * @return TestResponse
     */
    protected function getAllUsers(array $params = []): TestResponse
    {
        return $this->getJson(route('api.users.index', $params))->assertStatus(200);
    }

    /**
     * Return count of users
     *
     * @param array $params
     * @return int|null
     */
    protected function getUsersCount(array $params = []): ?int
    {
        $userRepo = new UserRepository(new User);
        return $userRepo->countUsers($params);
    }
}
