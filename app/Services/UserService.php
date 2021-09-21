<?php

namespace App\Services;

use App\Parameters\RegistrationParameters;
use App\Repository\Eloquent\CompanyRepository;
use App\Repository\Eloquent\UserRepository;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

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
     * @param RegistrationParameters $newUserParameters
     * @return Model
     */
    public function addUser(RegistrationParameters $newUserParameters): Model
    {

        $userParams = [
            'email' => $newUserParameters->email,
            'password' => $newUserParameters->hashedPassword,
            'type' => $newUserParameters->type
        ];

        if(env('APP_ENV') === 'local') {
            $userParams['email_verified_at'] = (new \DateTime('now', new \DateTimeZone('UTC')))->format('Y-m-d H:i:s');
        }

        $user = $this->userRepository->create($userParams);

        /** @var Company $company */
        $company = $this->companyRepository->create([
            'author_id' => $user->id
        ]);

        $company->users()->attach($user);

        return $user;

    }
}
