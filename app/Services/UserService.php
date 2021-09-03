<?php

namespace App\Services;

use App\Parameters\NewUserParameters;
use App\Repository\Eloquent\UserRepository;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class UserService
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param NewUserParameters $newUserParameters
     * @return Model
     */
    public function addUser(NewUserParameters $newUserParameters): Model
    {

        return $this->userRepository->create([
            'email' => $newUserParameters->email,
            'password' => $newUserParameters->hashedPassword,
            'type' => $newUserParameters->type
        ]);

    }
}
