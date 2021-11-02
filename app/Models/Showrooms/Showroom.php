<?php

namespace App\Models\Showrooms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showroom extends Model
{
    use HasFactory;

    protected $table = 'showrooms';

    protected $fillable = [
      'challenge_id',   'name'
    ];

    public function slides()
    {
        return $this->hasMany(ShowroomSlide::class);
    }

    public function visitors()
    {
        return $this->hasMany(ShowroomVisitor::class);
    }
}
