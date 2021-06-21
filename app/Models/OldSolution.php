<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldSolution extends Model
{
    use HasFactory;
    public $table = 'dbr_solutions';
    protected $fillable = [
        'deadline_offered', 'offered_installation_price', 'cycle_time', 'selected', 'rejected',
        'name', 'status', 'rejected', 'save_json', 'rate', 'screenshot_path',
        'installer_id', 'challenge_id', 'financial_after_id', 'author_id', 'published_at'
    ];


    public function author()
    {
        return $this->belongsTo(OldUser::class);
    }

    public function teams()
    {
        return $this->belongsToMany(OldTeam::class, 'teams_solutions');
    }

    public function installer()
    {
        return $this->belongsTo(OldUser::class);
    }

    public function challenge()
    {
        return $this->belongsTo(OldChallenge::class);
    }

}
