<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    public $table = 'solutions';
    protected $fillable = [
        'deadline_offered', 'offered_installation_price', 'cycle_time', 'selected', 'rejected',
        'name', 'status', 'save_json', 'rate', 'screenshot_path',
        'installer_id', 'challenge_id', 'financial_after_id', 'author_id', 'published_at'
    ];

//    public function rates()
//    {
//        return $this->hasMany(Rate::class);
//    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

//    public function teams()
//    {
//        return $this->belongsToMany(Team::class, 'teams_solutions');
//    }
//
//    public function installer()
//    {
//        return $this->belongsTo(User::class);
//    }

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

//    public function offers()
//    {
//        return $this->hasMany(Offer::class);
//    }

//    public function financial_after()
//    {
//        return $this->belongsTo(Financial::class);
//    }
//
//    public function estimate()
//    {
//        return $this->hasOne(Estimate::class);
//    }

//    public function analysis()
//    {
//        return $this->hasMany(Analysis::class);
//    }

}
