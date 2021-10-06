<?php

namespace App\Repository\Eloquent;

use App\Models\Team;

class TeamRepository extends BaseRepository
{

    /**
     * @param Team $user
     */
    public function __construct(Team $user)
    {
        parent::__construct($user);
    }

}
