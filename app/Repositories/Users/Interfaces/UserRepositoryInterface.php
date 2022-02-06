<?php
/**
 * @author Mojtaba Rahbari <mojtaba.rahbari@gmail.com | mojtabarahbari.ir>
 * @copyright Copyright &copy; from 2022 Mojtaba.
 * @version 1.0.0
 * @date 2022/02/06 15:00 PM
 */

namespace App\Repositories\Users\Interfaces;

use App\Base\Repositories\BaseRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function updateUser(array $params): User;

    public function listUsers(array $params = [], string $order = 'id', string $sort = 'desc'): Collection;

    public function createUser(array $params): User;

    public function findUserById(string $id): User;

    public function destroy(string $id);
}
