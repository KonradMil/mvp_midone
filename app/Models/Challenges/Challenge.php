<?php

namespace App\Models\Challenges;

use App\Models\File;
use App\Models\Financial;
use App\Models\Solutions\Solution;
use App\Models\Team;
use App\Models\TechnicalDetails;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableInterface;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Spatie\Tags\HasTags;
use BeyondCode\Comments\Traits\HasComments;

class Challenge extends Model implements ReactableInterface
{
    use Reactable, HasTags, HasComments;

    public $table = 'challenges';
    protected $fillable = [
        'type',
        'name', 'en_name', 'solution_deadline', 'offer_deadline', 'status', 'stage', 'save_json', 'screenshot_path',
        'client_id', 'author_id', 'financial_before_id', 'description', 'en_description', 'allowed_publishing'
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

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_challenge', 'challenge_id', 'team_id');
    }

    public function technicalDetails(){
        return $this->belongsTo(TechnicalDetails::class);
    }


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
    public function financial_before()
    {
        return $this->hasOne(Financial::class, 'id', 'financial_before_id');
    }

//    public function questions()
//    {
//        return $this->hasMany(Question::class);
//    }

}
