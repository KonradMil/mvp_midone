<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        'type', 'name', 'challenge_id', 'en_name', 'solution_deadline', 'offer_deadline', 'status',
        'stage', 'save_json', 'screenshot_path', 'description', 'en_description',
    ];

    /**
     * @return HasOne
     */
    public function challenge(): HasOne
    {
        return $this->hasOne(Challenge::class, 'id', 'challenge_id');
    }

    /**
     * @return HasOne
     */
    public function local_vision(): HasOne
    {
        return $this->hasOne(LocalVision::class, 'id', 'project_id');
    }
}
