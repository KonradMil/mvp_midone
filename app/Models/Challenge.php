<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Challenge extends Model
{
    public $table = 'challenges';
    protected $fillable = [
        'type', 'detail_weight', 'pick_quality',
        'detail_material', 'detail_size', 'detail_pick', 'detail_position', 'detail_range',
        'detail_destination', 'number_of_lines', 'cycle_time', 'work_shifts',
        'name', 'solution_deadline', 'offer_deadline', 'status', 'stage', 'save_json', 'screenshot_path',
        'client_id', 'author_id', 'financial_before_id', 'description'
    ];


//    public function rates()
//    {
//        return $this->hasMany(Rate::class);
//    }

    public function client()
    {
        return $this->belongsTo(User::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

//    public function teams()
//    {
//        return $this->belongsToMany(Team::class, 'teams_challenges');
//    }



    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function solutions()
    {
        return $this->hasMany(Solution::class);
    }

//    public function projects()
//    {
//        return $this->hasMany(Project::class);
//    }
//
//    public function workStations()
//    {
//        return $this->hasMany(WorkStation::class);
//    }

//    public function offers()
//    {
//        return $this->hasMany(Offer::class);
//    }
//
//    public function financial_before()
//    {
//        return $this->belongsTo(Financial::class);
//    }

//    public function questions()
//    {
//        return $this->hasMany(Question::class);
//    }

}
