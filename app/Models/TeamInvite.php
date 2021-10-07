<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class TeamInvite extends Model
{

    const TYPE_INVITE = 'invite';

    const TYPE_REQUEST = 'request';

    /**
     * @var string
     */
    protected $table = 'team_invites';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'team_id',
        'type',
        'email',
        'accept_token',
        'deny_token'
    ];


}
