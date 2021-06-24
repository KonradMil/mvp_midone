<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldChallenge extends Model
{
    use HasFactory;
    protected $table = 'dbr_challenges';

    protected $connection = 'old';

    public function client()
    {
        return $this->belongsTo(OldUser::class);
    }

    public function author()
    {
        return $this->belongsTo(OldUser::class);
    }

    public function teams()
    {
        return $this->belongsToMany(OldTeam::class, 'teams_challenges', 'challenge_id', 'team_id');
    }

    public function financial_before()
    {
        return $this->belongsTo(Financial::class);
    }

    public function solutions()
    {
        return $this->hasMany(OldSolution::class, 'challenge_id', 'id');
    }

    public function files()
    {
        return $this->hasMany(OldFile::class, 'file_id', 'challenge_id');
    }
}
