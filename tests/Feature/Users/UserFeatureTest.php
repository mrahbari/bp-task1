<?php
/**
 * @author Mojtaba Rahbari <mojtaba.rahbari@gmail.com | mojtabarahbari.ir>
 * @copyright Copyright &copy; from 2022 Mojtaba.
 * @version 1.0.0
 * @date 2022/02/06 15:00 PM
 */

namespace Tests\Feature\Users;

use App\Models\UserDetail;
use Tests\TestCase;

class UserFeatureTest extends TestCase
{

    /**
     * get all users
     */
    public function test_get_all_users()
    {
        $count = $this->getUsersCount();    //7
        $this->getAllUsers()->assertJsonCount($count, 'data');
    }

    /**
     * Get all users from austria country
     */
    public function test_get_all_users_from_austria()
    {
        $params = ['country_iso2' => 'AT'];
        $count = $this->getUsersCount($params); //3
        $this->getAllUsers($params)->assertJsonCount($count, 'data');
    }

    /**
     * Get active users from china
     */
    public function test_get_active_users_from_china()
    {
        $params = ['active' => 1, 'country_iso2' => 'RU'];
        $count = $this->getUsersCount($params); //1
        $this->getAllUsers($params)->assertJsonCount($count, 'data');
    }

    /**
     * Get all active users
     */
    public function test_get_active_users()
    {
        $params = ['active' => 1];
        $count = $this->getUsersCount($params); //5
        $this->getAllUsers($params)->assertJsonCount($count, 'data');
    }

    /**
     * Get all inactive users
     */
    public function test_get_inactive_users()
    {
        $params = ['active' => 0];
        $count = $this->getUsersCount($params); //2
        $this->getAllUsers($params)->assertJsonCount($count, 'data');
    }

    /**
     * Set an invalid value that set in params
     */
    public function test_get_an_error_if_an_invalid_active_value_is_sent()
    {
        $active = 'This is an incorrect active';
        $params = ['active' => $active];
        $this->getJson(route('api.users.index', $params))->assertStatus(422);
    }

    /**
     * Get all active users from austria
     */
    public function test_get_active_users_from_austria()
    {
        $params = ['active' => 1, 'country_iso2' => 'AT'];
        $count = $this->getUsersCount($params); //2
        $this->getJson(route('api.users.country'))->assertStatus(200)
            ->assertJsonCount($count, 'data')
            ->assertJsonPath('data.0.id', hashids_encode(6));
    }

    /**
     * Update users detail is possible
     */
    public function test_can_update_user_details()
    {
        $details = UserDetail::factory()->make()->toArray();
        $this->putJson(route('api.users.update_details', ['id' => hashids_encode(5)]), $details)
            ->assertStatus(202);
    }

    /**
     * Can not update because country Id should be exist in table
     */
    public function test_cannot_update_user_details_because_the_country_id_not_exist()
    {
        $details = UserDetail::factory()->make(['citizenship_country_id' => 66])->toArray();
        $this->putJson(route('api.users.update_details', ['id' => hashids_encode(5)]), $details)
            ->assertStatus(422);
    }

    /**
     * All fields are required for user detail updating
     */
    public function test_cannot_update_user_details_because_fields_are_all_required()
    {
        $this->putJson(route('api.users.update_details', ['id' => hashids_encode(5)]))
            ->assertStatus(422);
    }

    /**
     * User must have user details for updating
     */
    public function test_cannot_update_user_details_because_the_user_has_no_details()
    {
        $details = UserDetail::factory()->make()->toArray();
        $this->putJson(route('api.users.update_details', ['id' => hashids_encode(3)]), $details)
            ->assertStatus(400)
            ->assertJson([
                'data' => [
                    "error" => "The user doesn't have any details!",
                ]
            ]);
    }

    /**
     * users without user details are suit to delete
     */
    public function test_can_delete_an_user()
    {
        $this->deleteJson(route('api.users.destroy', ['id' => hashids_encode(3)]))
            ->assertStatus(202)
            ->assertJson([
                'data' => [
                    'success' => true,
                    'message' => 'Deleted information was successfully completed.',
                ]
            ]);
    }

    /**
     * Can not delete the users which has details
     */
    public function test_cannot_delete_a_user_if_it_has_details()
    {
        $this->deleteJson(route('api.users.destroy', ['id' => hashids_encode(5)]))
            ->assertStatus(400)
            ->assertJson([
                'data' => [
                    'error' => 'The user has details yet!',
                ]
            ]);
    }
}
