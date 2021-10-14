<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 */
class Financial extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'challenge_id', 'days', 'shifts', 'shift_time', 'weekend_shift', 'breakfast', 'stop_time', 'operator_performance',
        'defective', 'number_of_operators', 'operator_cost', 'absence', 'cycle_time', 'author_id'
    ];

    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function challenges(): BelongsTo
    {
        return $this->belongsTo(Challenge::class);
    }

    /**
     * @return BelongsTo
     */
    public function solutions(): BelongsTo
    {
        return $this->belongsTo(Solution::class);
    }

}
