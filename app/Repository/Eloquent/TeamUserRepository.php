<?php

namespace App\Repository\Eloquent;

use App\Models\TeamUser;
use Illuminate\Database\Eloquent\Builder;

/**
 *
 */
class TeamUserRepository extends BaseRepository
{

    /**
     * @param TeamUser $model
     */
    public function __construct(TeamUser $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $teamId
     * @param string $email
     * @return TeamUser|null
     */
    public function findTeamUserByEmail(int $teamId, string $email): ?TeamUser
    {
        return TeamUser::whereHas('user', function (Builder $query) use ($email) {
            $query->where('email', '=', $email);
        })->where('team_id', $teamId)
            ->first();
    }

}
