<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldTeam extends Model
{
    use HasFactory;

    protected $table = 'dbr_teams';

    protected $connection = 'old';

    public function users()
    {
        return $this->belongsTo(OldUser::class);
    }
}
