<?php

namespace App\Services;

use App\Models\User;
use App\Parameters\NewSocialUserParameters;
use App\Parameters\NewUserParameters;
use App\Repository\Eloquent\CompanyRepository;
use App\Repository\Eloquent\UserRepository;
use Exception;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;

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
     * @var CompanyRepository
     */
    private CompanyRepository $companyRepository;

    /**
     * @param UserRepository $userRepository
     * @param CompanyRepository $companyRepository
     */
    public function __construct(UserRepository $userRepository, CompanyRepository $companyRepository)
    {
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
    }

    /**
     * @param NewUserParameters $newUserParameters
     * @return Model
     * @throws Exception
     */
    public function addUser(NewUserParameters $newUserParameters): User
    {
        $userParams = [
            'email' => $newUserParameters->email,
            'password' => $newUserParameters->hashedPassword,
            'type' => $newUserParameters->type,
        ];

        if (env('APP_ENV') === 'local') {
            $userParams['email_verified_at'] = (new \DateTime('now', new \DateTimeZone('UTC')))->format('Y-m-d H:i:s');
        }

        /** @var User $user */
        $user = $this->userRepository->create($userParams);

        /** @var Company $company */
        $company = $this->companyRepository->create([
            'author_id' => $user->id
        ]);

        $company->users()->attach($user);

        return $user;

    }

    /**
     * @throws Exception
     */
    public function socialRegistration(NewSocialUserParameters $parameters): User
    {

        $userParams = [
            'email' => $parameters->email,
            'password' => Hash::make(''),
            'type' => $parameters->type,
            'name' => $parameters->firstName,
            'lastname' => $parameters->lastName,
            'facebook_id' => $parameters->facebookId,
            'google_id' => $parameters->googleId,
            'email_verified_at' => $parameters->emailVerifiedAt,
            'avatar' => $parameters->avatar
        ];

        /** @var User $user */
        $user = $this->userRepository->create($userParams);

        /** @var Company $company */
        $company = $this->companyRepository->create([
            'author_id' => $user->id
        ]);

        $company->users()->attach($user);

        return $user;
    }
}
