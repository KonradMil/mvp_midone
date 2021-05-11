<?php

namespace App\Models\Solutions;

use App\Models\Challenges\Challenge;
use App\Models\Financial;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableInterface;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Spatie\Tags\HasTags;
use BeyondCode\Comments\Traits\HasComments;

class Solution extends Model implements ReactableInterface
{
    use Reactable, HasTags, HasComments;

    public $table = 'solutions';
    protected $fillable = [
        'deadline_offered', 'offered_installation_price', 'cycle_time', 'selected', 'rejected',
        'name', 'status', 'save_json', 'rate', 'screenshot_path',
        'installer_id', 'challenge_id', 'financial_after_id', 'author_id', 'published_at'
    ];


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

    public function challenges()
    {
        return $this->belongsTo(Challenge::class);
    }

//    public function offers()
//    {
//        return $this->hasMany(Offer::class);
//    }

    public function financial_after()
    {
        return $this->belongsTo(Financial::class);
    }
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
