<?php

namespace App\Models\Challenges;

use App\Models\File;
use App\Models\Financial;
use App\Models\Offer;
use App\Models\Question;
use App\Models\Solutions\Solution;
use App\Models\Team;
use App\Models\TechnicalDetails;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableInterface;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Spatie\Tags\HasTags;
use BeyondCode\Comments\Traits\HasComments;

class Challenge extends Model implements ReactableInterface
{
    use Reactable, HasTags, HasComments;

    const TYPES = [
        "Pick & Place",
        "Montaż",
        "Kontrola jakości",
        "Malowanie",
        "Spawanie"
    ];

    const STAGES = [
        'draft',
        'awaiting solution',
        'awaiting offer',
        'agreement planning',
        'project planning',
        'project accepting',
        'invoicing'
    ];

    public $table = 'challenges';

    protected $fillable = [
        'type', 'name', 'en_name', 'solution_deadline', 'offer_deadline', 'status', 'stage', 'save_json', 'screenshot_path',
        'client_id', 'author_id', 'financial_before_id', 'description', 'en_description', 'allowed_publishing', 'selected_offer_id'
    ];

    protected $casts = [
        'name' => 'string',
        'type' => 'string',
        'en_name' => 'string',
        'description' => 'string',
        'en_description' => 'string',
        'status' => 'integer',
        'stage' => 'integer',
        'save_json' => AsArrayObject::class,
        'screenshot_path' => 'string',
        'allowed_publishing' => 'boolean',
        'solution_deadline' => 'timestamp',
        'offer_deadline' => 'timestamp',
    ];

    public function getStageName(): string
    {
        return self::STAGES[$this->attributes['stage']];
    }

    public function getTypeName(): string
    {
        return self::TYPES[$this->attributes['type']];
    }

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

    public function technicalDetails()
    {
        return $this->hasOne(TechnicalDetails::class);
    }

    public function files()
    {
        return $this->belongsToMany(File::class, 'challenge_image', 'challenge_id', 'image_id');
    }

    public function solutions()
    {
        return $this->hasMany(Solution::class, 'challenge_id', 'id');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function financial_before()
    {
        return $this->hasOne(Financial::class, 'id', 'financial_before_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

}
