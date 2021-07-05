<?php

namespace App\Models;

use App\Models\Solutions\Solution;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialAnalysis extends Model
{
    use HasFactory;

    protected $table = 'estimates';

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

    public function solution()
    {
        return $this->belongsTo(Solution::class, 'solution_id');
    }
}
