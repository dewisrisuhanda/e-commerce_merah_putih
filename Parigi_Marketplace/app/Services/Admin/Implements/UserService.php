<?php

namespace App\Services\Admin\Implements;

use App\Repositories\Admin\UserRepository;

class UserService implements \App\Services\Admin\UserService
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function getAllUsers(): array
    {
        return $this->userRepository->getAll();
    }
}
