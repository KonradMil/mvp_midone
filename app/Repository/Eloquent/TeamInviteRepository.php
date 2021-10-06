<?php

namespace App\Repository\Eloquent;

use App\Models\TeamInvite;

class TeamInviteRepository extends BaseRepository
{

    public function __construct(TeamInvite $model)
    {
        parent::__construct($model);
    }

    public function findByEmailAndTeam(string $userEmail, int $invitationId)
    {
        return TeamInvite::where('email', '=', $userEmail)
            ->where('team_id', '=', $invitationId)
            ->first();
    }

}
