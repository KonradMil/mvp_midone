<?php

namespace App\Repository\Eloquent;

use App\Models\TeamUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class TeamUserRepository extends BaseRepository
{

    public function __construct(TeamUser $model)
    {
        parent::__construct($model);
    }

    public function findTeamUserByEmail(int $teamId, string $email)
    {
        return TeamUser::whereHas('user', function(Builder $query) use($email){
                $query->where('email', '=', $email);
            })->where('team_id', $teamId)
            ->first();
    }

}
