<?php

namespace App\Models;



use App\Models\Challenges\Challenge;
use App\Models\Solutions\Solution;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';

    protected $fillable =[
        'owner_id', 'name'
    ];

    public function users () {
        return $this->belongsToMany(User::class, 'team_user')->withPivot('publishChallenge', 'editChallenge', 'acceptChallengeOffer', 'publishSolution', 'canEditSolution', 'canDeleteSolution','addSolutionOffer','acceptChallengeSolution', 'showSolutions')->using(TeamUser::class)->withTimestamps();
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
        return $this->belongsToMany(Solution::class, 'team_solution');
    }

}
