<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 */
class File extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'files';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'ext', 'original_name', 'path', 'thumbnail', 'size', 'alt', 'tags', 'author_id'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'tags' => 'array'
    ];

    /**
     * @return BelongsToMany
     */
    public function reports(): BelongsToMany
    {
        return $this->belongsToMany(Report::class, 'file_reports');
    }

    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'author_id');
    }

    /**
     * @return BelongsToMany
     */
    public function challenges(): BelongsToMany
    {
        return $this->belongsToMany(File::class, 'challenge_image', 'image_id', 'challenge_id');
    }

    /**
     * @return BelongsToMany
     */
    public function solutions(): BelongsToMany
    {
        return $this->belongsToMany(File::class);
    }

    /**
     * @return BelongsToMany
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(File::class);
    }

}
