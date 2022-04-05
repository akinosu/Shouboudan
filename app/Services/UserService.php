<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;

class UserService
{
    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepositry = $userRepo;
    }

    public function updateProfile($params)
    {
        return $this->userRepositry->updateProfile($params);
    }
}
