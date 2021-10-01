<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 */
class TechnicalDetails extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'technical_details';

    /**
     * @var string[]
     */
    protected $fillable = [
        'challenge_id', 'detail_weight', 'pick_quality',
        'detail_material', 'detail_size', 'detail_pick', 'detail_position', 'detail_range',
        'detail_destination', 'number_of_lines', 'cycle_time', 'work_shifts',
    ];


    /**
     * @return BelongsTo
     */
    public function challenge(): BelongsTo
    {
        return $this->belongsTo(Challenge::class);
    }
}
