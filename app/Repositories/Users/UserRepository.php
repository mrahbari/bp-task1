<?php
/**
 * @author Mojtaba Rahbari <mojtaba.rahbari@gmail.com | mojtabarahbari.ir>
 * @copyright Copyright &copy; from 2022 Mojtaba.
 * @version 1.0.0
 * @date 2022/02/06 15:00 PM
 */

namespace App\Repositories\Users;

use App\Base\Repositories\BaseRepository;
use App\Exceptions\UserDetails\UserDetailExistException;
use App\Exceptions\UserDetails\UserDetailFoundException;
use App\Exceptions\Users\UserInvalidArgumentException;
use App\Exceptions\Users\UserNotFoundException;
use App\Models\User;
use App\Repositories\Users\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Throwable;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
        $this->model = $user;
    }

    /**
     * List all the users
     *
     * @param array $params
     * @param string $order
     * @param string $sort
     * @return Collection
     *
     * select * from `tbl_users` where exists
     * (select * from `tbl_user_details` where `tbl_users`.`id` = `tbl_user_details`.`user_id` and exists
     * (select * from `tbl_countries` where `tbl_user_details`.`citizenship_country_id` = `tbl_countries`.`id` and `iso2` = 'RU'))
     * order by `id` desc
     */
    public function listUsers(array $params = [], string $order = 'id', string $sort = 'desc'): Collection
    {
        return $this->model->query()->search($params)->orderBy($order, $sort)->get();
    }

    /**
     * Return user count based on params
     * @param array $params
     * @return int|null
     */
    public function countUsers(array $params = []): ?int
    {
        return $this->model->query()->search($params)->count();
    }

    /**
     * Edit user details just if the user details are there already.
     *
     * @param string $id
     * @param array $attributes
     * @throws UserDetailFoundException
     */
    public function updateDetails(string $id, array $attributes = []): void
    {
        $id = hashids_decode($id);
        $user = $this->model->query()->findOrFail($id);

        if (empty($user->has_details) || !$user->has_details) {
            throw new UserInvalidArgumentException("The user doesn't have any details!");
        }

        try {
            $user->details->update($attributes);
        } catch (Throwable $th) {
            throw new UserDetailFoundException($th->getMessage());
        }
    }

    /**
     * Remove the specified user just if no user details exist yet.
     *
     * @param string $id
     * @throws UserDetailExistException
     * @throws UserDetailFoundException
     */
    public function destroy(string $id)
    {
        $id = hashids_decode($id);
        $user = $this->model->query()->findOrFail($id);

        if ($user->has_details === true) {
            throw new UserDetailExistException("The user has details yet!");
        }

        try {
            $this->model->delete();
        } catch (Throwable $th) {
            throw new UserDetailFoundException($th->getMessage());
        }

    }

    /**
     * Create a user
     * @param array $params
     * @return User
     */
    public function createUser(array $params): User
    {
        return $this->create($params);
    }

    /**
     * Update the user
     *
     * @param array $params
     * @return User
     * @throws UserNotFoundException
     */
    public function updateUser(array $params): User
    {
        try {
            $this->model->update($params);
            return $this->findUserById($this->model->id);
        } catch (QueryException $e) {
            throw new UserInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Find the user
     *
     * @param string $id
     * @return User
     * @throws UserNotFoundException
     */
    public function findUserById(string $id): User
    {
        try {
            $id = hashids_decode($id);
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException('User not found.');
        }
    }


}
