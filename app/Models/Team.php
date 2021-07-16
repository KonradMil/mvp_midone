<?php

namespace App\Models;



use App\Models\Challenges\Challenge;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';

    protected $fillable =[
        'owner_id', 'name'
    ];

    public function users () {
        return $this->belongsToMany(User::class, 'team_user')->using(TeamUser::class)->withPivot('publishChallenge', 'acceptChallengeOffer', 'publishSolution', 'addSolutionOffer','acceptChallengeSolution');
    }

    public function invites () {
        return $this->belongsToMany(TeamInvite::class, 'team_invites');
    }

    public function challenges()
    {
        return $this->belongsToMany(Challenge::class, 'team_challenge');
    }

    public function solutions()
    {
        return $this->belongsToMany(Challenge::class, 'team_challenge');
    }

}
