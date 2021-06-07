<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldUser extends Model
{
    use HasFactory;
    protected $table = 'aiods_users';

    protected $connection = 'old';

    public function teams()
    {
        return $this->belongsToMany(OldTeam::class, 'dbr_team_users');
    }
}
