<?php

namespace App\Models;

use Mpociot\Teamwork\TeamworkTeam;

class Team extends TeamworkTeam
{
    protected $fillable =[
        'owner_id', 'name'
    ];
}
