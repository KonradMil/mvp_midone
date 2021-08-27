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
class LocalVision extends Model implements ReactableInterface
{
    use Reactable, HasTags, HasComments;

    /**
     * @var string
     */
    public $table = 'local_visions';

    /**
     * @var string[]
     */
    protected $fillable = [
        'project_id', 'description', 'before', 'after'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'project_id' => 'int',
        'description' => 'string',
        'before' => 'string',
        'after' => 'string',
    ];

    /**
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'id', 'project_id');
    }
}
