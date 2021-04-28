<?php

namespace App\Models\Reports;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableInterface;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Spatie\Tags\HasTags;
use BeyondCode\Comments\Traits\HasComments;

class Report extends Model
{
    use HasTags, HasComments;

    public $table = 'reports';
    protected $fillable = [
        'type',
        'title',
        'description',
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
