<?php
/**
 * @author Mojtaba Rahbari <mojtaba.rahbari@gmail.com | mojtabarahbari.ir>
 * @copyright Copyright &copy; from 2022 Mojtaba.
 * @version 1.0.0
 * @date 2022/02/06 15:00 PM
 */

namespace App\Http\Controllers\Api\V1\Users;

use App\Base\Http\Controllers\BaseApiController;
use App\Exceptions\UserDetails\UserDetailFoundException;
use App\Http\Requests\Users\SearchUserRequest;
use App\Http\Requests\Users\UpdateDetailFromUserRequest;
use App\Http\Requests\Users\UserRequest;
use App\Http\Resources\Users\UserCollection;
use App\Http\Resources\Users\UserResource;
use App\Repositories\Users\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;

class UserController extends BaseApiController
{

    /**
     * Default value for country iso2
     */
    const DEFAULT_COUNTRY_ISO2 = 'AT';

    /**
     * Default value for user status
     */
    const DEFAULT_ACTIVE = true;

    /**
     * UserController constructor.
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    /**
     * Display a listing of the users.
     */
    public function index(SearchUserRequest $request): UserCollection
    {
        $users = $this->repository->listUsers();
        return new UserCollection($users);
    }

    /**
     * Display a listing of the users which are `active` (users table) and have an Austrian citizenship.
     *
     * @param SearchUserRequest $request
     * @return UserCollection
     */
    public function getAustrianCountryIsoAndActiveUsers(SearchUserRequest $request): UserCollection
    {
        //DB::enableQueryLog(); // Enable query log
        $params = ['country_iso2' => $this::DEFAULT_COUNTRY_ISO2, 'active' => $this::DEFAULT_ACTIVE];
        $austrianUsers = $this->repository->listUsers($params);
        //dd(DB::getQueryLog());

        return new UserCollection($austrianUsers);
    }


    /**
     * Edit user details just if the user details are there already.
     *
     * @param UpdateDetailFromUserRequest $request
     * @param string $id
     * @return JsonResponse
     * @throws UserDetailFoundException
     */
    public function updateDetails(UpdateDetailFromUserRequest $request, string $id): JsonResponse
    {
        //return $this->apiFailed();
        $attributes = $request->validated();
        $this->repository->updateDetails($id, $attributes);
        return $this->apiUpdated();
    }

    /**
     * Remove the specified user just if no user details exist yet.
     *
     * @param UserRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(UserRequest $request, string $id): JsonResponse
    {
        $this->repository->destroy($id);
        return $this->apiDeleted();
    }


    /**
     * Display the specified user.
     *
     * @param UserRequest $request
     * @param string $id
     * @return UserResource
     */
    public function show(UserRequest $request, string $id): UserResource
    {
        $user = $this->repository->findUserById($id);
        return new UserResource($user);
    }
}
