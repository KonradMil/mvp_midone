<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 *
 */
class TeamUser extends Pivot
{

    /**
     * @var string
     */
    protected $table = 'team_user';

    /**
     * @var string[]
     */
    protected $fillable = [
        'publishChallenge',
        'editChallenge',
        'owner',
        'acceptChallengeSolution',
        'acceptChallengeOffer',
        'publishSolution',
        'canEditSolution',
        'canDeleteSolution',
        'addSolutionOffer',
        'showSolutions'
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
