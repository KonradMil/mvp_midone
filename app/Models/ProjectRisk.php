<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectRisk extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    public $table = 'project_communications';

    /**
     * @var string[]
     */
    protected $fillable = [
        'project_id', 'author_id',
        'risk_description', 'risk_area', 'event_probability',
        'cost_impact', 'schedule_impact', 'quality_implementation_impact', 'risk_limitations',
        'comment_integrator', 'comment_investor', 'is_accepted',
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
