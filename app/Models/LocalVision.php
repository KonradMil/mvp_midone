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

//    /**
//     * @return BelongsTo
//     */
//    public function project(): BelongsTo
//    {
//        return $this->belongsTo(Project::class, 'id', 'project_id');
//    }
}
