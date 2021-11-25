<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class UserRepository extends BaseRepository
{

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**
     * @param string $email
     * @return mixed
     */
    public function findByEmail(string $email)
    {
        return User::where('email', '=', $email)->first();
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function getUserWithCompanies(int $id)
    {
        $user = User::where('id', '=', $id)->with('companies')->first();

        return $user;
    }

    public function findImpersonator(string $impersonationToken)
    {
        return User::where('impersonation_token', '=', $impersonationToken)->first();
    }
}
