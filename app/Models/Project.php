<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Tags\HasTags;


/**
 *
 */
class Project extends Model
{
    use HasTags;

    /**
     * @var string
     */
    public $table = 'projects';

    /**
     * @var string[]
     */
    protected $fillable = [
        'type', 'name', 'challenge_id', 'en_name',
        'stage','description', 'en_description',
        'project_accept_offer', 'project_accept_details', 'project_accept_vision'
    ];

    /**
     * @return BelongsTo
     */
    public function challenge(): BelongsTo
    {
        return $this->BelongsTo(Challenge::class, 'id', 'challenge_id');
    }

    /**
     * @return HasMany
     */
    public function local_visions(): HasMany
    {
        return $this->hasMany(LocalVision::class, 'id', 'project_id');
    }
}
