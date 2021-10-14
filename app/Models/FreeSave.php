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


class FreeSave extends Model implements ReactableInterface
{
    use Reactable, HasComments;


    /**
     * @var string
     */
    public $table = 'free_saves';

    /**
     * @var string[]
     */
    protected $fillable = [
       'name', 'en_name', 'save_json', 'screenshot_path',
       'description', 'en_description'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'name' => 'string',
        'en_name' => 'string',
        'description' => 'string',
        'en_description' => 'string',
        'save_json' => JsonAsArrayObjectWithNull::class,
        'screenshot_path' => 'string',
    ];


    /**
     * @return BelongsTo
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'free_saves_user', 'free_save_id');
    }

    public function getOwner(): User {
        return $this->users()->wherePivot('is_owner', 1);
    }

}
