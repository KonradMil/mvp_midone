<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 */
class Estimate extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'estimates';

    /**
     * @var string[]
     */
    protected $fillable = [
        'solution_id',
        'integration_cost',
        'parts_cost',
        'mechanical_integration',
        'electrical_integration',
        'workstation_integration',
        'programming_robot',
        'programming_plc',
        'documentation_ce',
        'training',
        'project',
        'margin',
        'parts_prices',
        'additionalCosts',
        'parts_ar',
        'sum'
    ];

    /**
     * @return BelongsTo
     */
    public function solution(): BelongsTo
    {
        return $this->belongsTo(Solution::class, 'solution_id');
    }
}
