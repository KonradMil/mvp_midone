<?php

namespace App\Modules\Dbr\Module\Models;

use Aiods\Foundation\Models\User;
use Aiods\Foundation\Support\Facades\Model;
use Carbon\Carbon;

class Team extends Model
{
    public $table = 'dbr_teams';
    protected $fillable = [
        'name', 'author_id'
    ];


    public function author()
    {
        return $this->belongsTo(User::class);
    }

//    public function members()
//    {
//        return $this->hasMany(User::class);
//    }

    public function solutions()
    {
        return $this->belongsToMany(Solution::class, 'teams_solutions');
    }

    public function challenges()
    {
        return $this->belongsToMany(Challenge::class, 'teams_challenges');
    }

    public function team_users()
    {
        return $this->hasMany(TeamUser::class);
    }

}
