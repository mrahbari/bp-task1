<?php
/**
 * @author Mojtaba Rahbari <mojtaba.rahbari@gmail.com | mojtabarahbari.ir>
 * @copyright Copyright &copy; from 2022 Mojtaba.
 * @version 1.0.0
 * @date 2022/02/06 15:00 PM
 */

namespace App\Policies\UserDetails;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserDetailPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param UserDetail $userDetail
     * @return bool
     */
    public function view(User $user, UserDetail $userDetail): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param UserDetail $userDetail
     * @return bool
     */
    public function update(User $user, UserDetail $userDetail): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param UserDetail $userDetail
     * @return bool
     */
    public function delete(User $user, UserDetail $userDetail): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param UserDetail $userDetail
     * @return bool
     */
    public function restore(User $user, UserDetail $userDetail): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param UserDetail $userDetail
     * @return bool
     */
    public function forceDelete(User $user, UserDetail $userDetail): bool
    {
        return true;
    }
}
