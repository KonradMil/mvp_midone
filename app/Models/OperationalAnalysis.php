<?php

namespace App\Models;

use App\Models\Solutions\Solution;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationalAnalysis extends Model
{
    use HasFactory;

    protected $table = 'estimates';

    protected $fillable = [
      'solution_id',
      'time_available',
      'time_production',
      'production',
      'good_arts_production',
      'availability_factor',
      'productivity_coefficient	',
      'quality_factor',
      'oee',
      'production_volume',
      'pph_per_person',
    ];

    public function solution()
    {
        return $this->belongsTo(Solution::class, 'solution_id');
    }
}
