<?php

namespace App\Models;

use App\Models\Solutions\Solution;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationalAnalysis extends Model
{
    use HasFactory;

    protected $table = 'operational_analyses';

    protected $fillable = [
      'solution_id',
      'time_available_before',
      'time_available_after',
      'time_available_change',
      'time_production_before',
      'time_production_after',
      'time_production_change',
      'production_before',
      'production_after',
      'production_change',
      'good_arts_production_before',
      'good_arts_production_after',
      'good_arts_production_change',
      'availability_factor_before',
      'availability_factor_after',
      'availability_factor_change',
      'productivity_coefficient_before',
      'productivity_coefficient_after',
      'productivity_coefficient_change',
      'quality_factor_before',
      'quality_factor_after',
      'quality_factor_change',
      'oee_before',
      'oee_after',
      'oee_change',
      'production_volume_before',
      'production_volume_after',
      'production_volume_change',
      'pph_per_person_before',
      'pph_per_person_after',
      'pph_per_person_change',
    ];

    public function solution()
    {
        return $this->belongsTo(Solution::class, 'solution_id');
    }
}
