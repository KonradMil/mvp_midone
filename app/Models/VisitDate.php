<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitDate extends Model
{
    use HasFactory;
    /**
     * @var string
     */
    public $table = 'visit_dates';

    /**
     * @var string[]
     */
    protected $fillable = [
        'project_id', 'author_id', 'date',
        'status', 'members', 'time' , 'accepted'
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
