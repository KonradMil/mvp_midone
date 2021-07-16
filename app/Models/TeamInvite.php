<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamInvite extends Model
{
    protected $table = 'team_invites';

    protected $fillable = [
        'user_id',
        'team_id',
        'type',
        'email',
        'accept_token',
        'deny_token'
    ];

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_invites', 'team_invite_id', 'team_id');
    }
}
