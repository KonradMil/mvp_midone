<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *
 */
class Team extends Model
{
    /**
     * @var string
     */
    protected $table = 'teams';

    /**
     * @var string[]
     */
    protected $fillable = [
        'owner_id', 'name'
    ];

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_user')->withPivot('publishChallenge', 'editChallenge', 'acceptChallengeOffer', 'publishSolution', 'canEditSolution', 'canDeleteSolution', 'addSolutionOffer', 'acceptChallengeSolution', 'showSolutions')->using(TeamUser::class)->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function invites(): BelongsToMany
    {
        return $this->belongsToMany(TeamInvite::class, 'team_invites');
    }

    /**
     * @return BelongsToMany
     */
    public function challenges(): BelongsToMany
    {
        return $this->belongsToMany(Challenge::class, 'team_challenge');
    }

    /**
     * @return BelongsToMany
     */
    public function solutions(): BelongsToMany
    {
        return $this->belongsToMany(Solution::class, 'team_solution');
    }

}
