<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\Pivot;

class TeamUser extends Pivot
{

    protected $table = 'team_user';

    protected $fillable = [
        'publishChallenge',
        'editChallenge',
        'owner',
        'acceptChallengeSolution',
        'acceptChallengeOffer',
        'publishSolution',
        'addSolutionOffer',
        'addChallengeSolution'
    ];

}
