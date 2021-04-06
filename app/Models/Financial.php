<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financial extends Model
{
    use HasFactory;

    protected $fillable = [
        'days', 'shifts', 'shift_time', 'weekend_shift', 'breakfast', 'stop_time', 'operator_performance',
        'defective', 'number_of_operators', 'operator_cost', 'absence', 'cycle_time', 'author_id'
    ];

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
