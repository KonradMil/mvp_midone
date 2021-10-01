<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'type', 'name', 'challenge_id', 'status', 'en_name',
        'stage','description', 'en_description',
        'accept_offer', 'accept_technical_details',
        'accept_local_vision', 'accept_financial_details',
        'accept_visit_date', 'selected_offer_id'
    ];

    /**
     * @return BelongsTo
     */
    public function challenge(): BelongsTo
    {
        return $this->BelongsTo(Challenge::class, 'id', 'challenge_id');
    }

    /**
     * @return HasMany
     */
    public function local_visions(): HasMany
    {
        return $this->hasMany(LocalVision::class, 'id', 'project_id');
    }
    /**
     * @return HasMany
     */
    public function visit_dates(): HasMany
    {
        return $this->hasMany(VisitDate::class, 'id', 'project_id');
    }
}
