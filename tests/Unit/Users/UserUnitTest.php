<?php
/**
 * @author Mojtaba Rahbari <mojtaba.rahbari@gmail.com | mojtabarahbari.ir>
 * @copyright Copyright &copy; from 2022 Mojtaba.
 * @version 1.0.0
 * @date 2022/02/06 15:00 PM
 */

namespace Tests\Unit\Users;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserUnitTest extends TestCase
{
    protected string $model = User::class;

    /**
     * A basic test to check whether relation exist.
     *
     * @return void
     */
    public function test_model_has_country_trough_relation()
    {
        $existRelation = method_exists(User::class, 'countryThrough');
        $this->assertTrue($existRelation, '"Country Through" relation does not exist in user model.');
    }

    /**
     * A basic test to check whether relation exist.
     *
     * @return void
     */
    public function test_model_has_user_detail_relation()
    {
        $existRelation = method_exists(User::class, 'details');
        $this->assertTrue($existRelation, '"User Details" relation does not exist in user model.');
    }

    /**
     * A basic test to check whether relation exist.
     *
     * @return void
     */
    /*public function test_model_has_a_row_in_user_detail_relation()
    {
        $existRelation = method_exists(User::class, 'hasDetails');
        $this->assertTrue($existRelation, '"Has User Details" relation does not exist in user model.');
    }*/
}
