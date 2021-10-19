<?php

namespace App\Models;

use App\Models\Casts\JsonAsArrayObjectWithNull;
use Illuminate\Database\Eloquent\Model;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableInterface;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Tags\HasTags;
use BeyondCode\Comments\Traits\HasComments;


class Challenge extends Model implements ReactableInterface
{
    use Reactable, HasTags, HasComments;

    /**
     *
     */
    const TYPES = [
        "Pick & Place",
        "Montaż",
        "Kontrola jakości",
        "Malowanie",
        "Spawanie"
    ];

    /**
     *
     */
    const CATEGORIES = [
        'default',
        'test',
        'showoff'
    ];

    /**
     *
     */
    const STAGES = [
        'draft',
        'awaiting solution',
        'awaiting offer',
        'agreement planning',
        'project planning',
        'project accepting',
        'invoicing'
    ];

    /**
     * @var string
     */
    public $table = 'challenges';

    /**
     * @var string[]
     */
    protected $fillable = [
        'type', 'name', 'en_name', 'solution_deadline', 'offer_deadline', 'status', 'stage', 'save_json', 'screenshot_path',
        'client_id', 'author_id', 'financial_before_id', 'description', 'en_description', 'allowed_publishing', 'selected_offer_id',
        'project_accept_offer', 'project_accept_details', 'project_accept_vision'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'name' => 'string',
        'type' => 'string',
        'en_name' => 'string',
        'description' => 'string',
        'en_description' => 'string',
        'status' => 'integer',
        'stage' => 'integer',
        'save_json' => JsonAsArrayObjectWithNull::class,
        'screenshot_path' => 'string',
        'allowed_publishing' => 'boolean',
        'solution_deadline' => 'timestamp',
        'offer_deadline' => 'timestamp'
    ];

    /**
     * @return string
     */
    public function getStageName(): string
    {
        return self::STAGES[$this->attributes['stage']];
    }

    /**
     * @return string
     */
    public function getTypeName(): string
    {
        return self::TYPES[$this->attributes['type']];
    }

    /**
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_challenge', 'challenge_id', 'team_id');
    }

    /**
     * @return HasOne
     */
    public function technicalDetails(): HasOne
    {
        return $this->hasOne(TechnicalDetails::class);
    }

    /**
     * @return BelongsToMany
     */
    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class, 'challenge_image', 'challenge_id', 'image_id');
    }

    /**
     * @return HasMany
     */
    public function solutions(): HasMany
    {
        return $this->hasMany(Solution::class, 'challenge_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function solutionSelected(): HasOne
    {
        return $this->hasOne(Solution::class)->where('selected', '=', 1);
    }

    /**
     * @return HasMany
     */
    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }

    /**
     * @return HasOne
     */
    public function financial_before(): HasOne
    {
        return $this->hasOne(Financial::class, 'id', 'financial_before_id');
    }

    /**
     * @return HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
    /**
     * @return HasOne
     */
    public function project(): HasOne
    {
        return $this->hasOne(Project::class);
    }

}
