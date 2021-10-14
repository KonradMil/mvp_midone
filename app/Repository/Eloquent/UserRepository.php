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
     */
    public function getUserWithCompanies(int $id)
    {
        $user = User::where('id', '=', $id)->with('companies')->first();

        return $user;
    }
}
