<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Tags\HasTags;
use BeyondCode\Comments\Traits\HasComments;

/**
 *
 */
class Report extends Model
{
    use HasTags, HasComments;

    /**
     * @var string
     */
    public $table = 'reports';

    /**
     * @var string[]
     */
    protected $fillable = [
        'type',
        'title',
        'description',
        'author_id'
    ];

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
    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class, 'file_reports');
    }

    /**
     * @return HasMany
     */
    public function solutions(): HasMany
    {
        return $this->hasMany(Solution::class);
    }

}
