<?php

namespace App\Modules\Dbr\Module\Models;

use Aiods\Foundation\Models\User;
use Aiods\Foundation\Support\Facades\Model;
use Carbon\Carbon;

class TeamUser extends Model
{
    public $table = 'dbr_team_users';
    protected $fillable = [
        'team_id', 'user_id'
    ];
    public $timestamps = false;

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
