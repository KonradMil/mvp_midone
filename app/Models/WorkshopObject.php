<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *
 */
class WorkshopObject extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    public $table = 'workshop_objects';

    /**
     * @var string[]
     */
    protected $fillable = [
        'save', 'name', 'author_id', 'screenshot_path', 'public', 'description', 'type'
    ];

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_workshop_objects', 'workshop_object_id', 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
