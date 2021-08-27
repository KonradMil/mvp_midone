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


/**
 *
 */
class Project extends Model implements ReactableInterface
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
    public $table = 'projects';

    /**
     * @var string[]
     */
    protected $fillable = [
        'type', 'name', 'challenge_id', 'en_name', 'solution_deadline', 'offer_deadline', 'status',
        'stage', 'save_json', 'screenshot_path', 'description', 'en_description',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'name' => 'string',
        'type' => 'string',
        'challenge_id' => 'integer',
        'en_name' => 'string',
        'description' => 'string',
        'en_description' => 'string',
        'status' => 'integer',
        'stage' => 'integer',
        'save_json' => JsonAsArrayObjectWithNull::class,
        'screenshot_path' => 'string',
        'allowed_publishing' => 'boolean',
        'solution_deadline' => 'timestamp',
        'offer_deadline' => 'timestamp',
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
     * @return HasOne
     */
    public function challenge(): HasOne
    {
        return $this->hasOne(Challenge::class, 'id', 'challenge_id');
    }
}
