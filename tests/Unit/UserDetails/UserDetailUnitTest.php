<?php
/**
 * @author Mojtaba Rahbari <mojtaba.rahbari@gmail.com | mojtabarahbari.ir>
 * @copyright Copyright &copy; from 2022 Mojtaba.
 * @version 1.0.0
 * @date 2022/02/06 15:00 PM
 */

namespace Tests\Unit\UserDetails;

use App\Models\Country;
use App\Models\User;
use App\Models\UserDetail;
use Tests\TestCase;

class UserDetailUnitTest extends TestCase
{
    /**
     * A basic test to check whether relation exist.
     *
     * @return void
     */
    public function test_model_has_country_trough_relation(): void
    {
        $existRelation = method_exists(User::class, 'countryThrough');
        $this->assertTrue($existRelation, '"Country Through" relation does not exist in user model.');
    }

    /**
     * A basic test to check whether relation exist.
     *
     * @return void
     */
    public function test_model_has_user_detail_relation(): void
    {
        $existRelation = method_exists(UserDetail::class, 'user');
        $this->assertTrue($existRelation, '"User" relation does not exist in user model.');
    }

    /**
     * A basic test to check whether relation exist.
     *
     * @return void
     */
    public function test_model_has_a_row_in_user_detail_relation(): void
    {
        $existRelation = method_exists(User::class, 'country2');
        $this->assertFalse($existRelation, '"country2" relation does not exist in user model.');
    }

    /**
     * created record has valid parent or user
     *
     * @return void
     */
    public function test_user_detail_is_healthy(): void
    {
        $user = User::factory()->create();
        $userDetail = UserDetail::factory()->state(['user_id' => $user])->create();
        $this->assertModelExists($user);
        $this->assertInstanceOf(User::class, $userDetail->user);
        $this->assertDatabaseHas('user_details', ['user_id' => $user->id]);
    }

    /**
     * created record has valid parent or user
     *
     * @return void
     */
    public function test_belongs_to_user(): void
    {
        $userDetail = UserDetail::query()->inRandomOrder()->first();
        $this->assertInstanceOf(User::class, $userDetail->user);
    }

    /**
     * Created record has valid country
     *
     * @return void
     */
    public function test_belongs_to_country(): void
    {
        $userDetail = UserDetail::query()->inRandomOrder()->first();
        $this->assertInstanceOf(Country::class, $userDetail->country);
    }

    /**
     * Creating new record via factory is possible
     *
     * @return void
     */
    public function test_can_add_a_user_detail(): void
    {
        $UserDetail = UserDetail::query()->inRandomOrder()->first();
        $this->assertNotNull($UserDetail);
    }

}
