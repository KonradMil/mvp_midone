<?php

namespace App\Models;

use App\Models\Solutions\Solution;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    use HasFactory;

    protected $table = 'estimates';

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
        'additionalCosts'
    ];

    public function solution()
    {
        return $this->belongsTo(Solution::class, 'solution_id');
    }
}
