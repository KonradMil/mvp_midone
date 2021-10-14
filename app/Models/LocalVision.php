<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



/**
 *
 */
class LocalVision extends Model
{

    /**
     * @var string
     */
    public $table = 'local_visions';

    /**
     * @var string[]
     */
    protected $fillable = [
        'project_id', 'author_id',
        'description', 'before', 'after',
        'accepted', 'comment'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'project_id' => 'int',
        'author_id' => 'int',
        'description' => 'string',
        'before' => 'string',
        'after' => 'string',
        'accepted' => 'int',
        'comment' => 'string'
    ];

    /**
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'id', 'project_id');
    }
    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
