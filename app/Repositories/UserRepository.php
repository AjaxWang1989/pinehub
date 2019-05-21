<?php

namespace App\Repositories;

use App\Entities\User;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserRepository.
 *
 * @package namespace App\Repositories;
 */
interface UserRepository extends RepositoryInterface
{
    public function pushCriteria($class);

    public function getBalance(User $user);
}
