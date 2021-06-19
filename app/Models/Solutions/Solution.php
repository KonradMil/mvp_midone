<?php

namespace App\Models\Solutions;

use App\Models\Challenges\Challenge;
use App\Models\Estimate;
use App\Models\Financial;
use App\Models\Offer;
use App\Models\Team;
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

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_solution', 'solution_id', 'team_id');
    }

    public function estimate()
    {
        return $this->hasOne(Estimate::class, 'solution_id');
    }

    public function challenge()
    {
        return $this->belongsTo(Challenge::class, 'challenge_id');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function financial_after()
    {
        return $this->hasOne(Financial::class, 'id' , 'financial_after_id');
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
