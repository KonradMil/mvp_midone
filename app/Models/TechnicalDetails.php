<?php

namespace App\Models;

use App\Models\Challenges\Challenge;
use App\Models\Solutions\Solution;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalDetails extends Model
{
    use HasFactory;

    protected $table = 'technical_details';

    protected $fillable = [
        'detail_weight', 'pick_quality',
        'detail_material', 'detail_size', 'detail_pick', 'detail_position', 'detail_range',
        'detail_destination', 'number_of_lines', 'cycle_time', 'work_shifts',
    ];


    public function challenge()
    {
        return $this->hasOne(Challenge::class, 'id', 'challenge_id');
    }
}
