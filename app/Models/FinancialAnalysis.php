<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 */
class FinancialAnalysis extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'financial_analyses';

    /**
     * @var string[]
     */
    protected $fillable = [
        'solution_id',
        'cost_per_hour_before',
        'cost_per_hour_after',
        'cost_per_year_before',
        'cost_per_year_after',
        'cost_per_piece_before',
        'cost_per_piece_after',
        'monthly_reduction_before',
        'monthly_reduction_after',
        'monthly_savings_before',
        'monthly_savings_after',
        'tkw_reduction_before',
        'tkw_reduction_after',
        'additional_savings_before',
        'additional_savings_after',
        'capex',
        'cost_capital',
        'timeframe',
        'monthly_savings',
        'simple_payback',
        'npv',
    ];

    /**
     * @return BelongsTo
     */
    public function solution(): BelongsTo
    {
        return $this->belongsTo(Solution::class, 'solution_id');
    }
}
