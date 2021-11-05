<?php

namespace App\Models\Showrooms;

use App\Models\Challenge;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showroom extends Model
{
    use HasFactory;

    protected $table = 'showrooms';

    protected $fillable = [
        'name', 'custom_css', 'custom_functions', 'description', 'organization', 'organization_logo', 'dominant_color'
    ];

    public function challenge()
    {
        return $this->belongsTo(Challenge::class, 'challenge_id');
    }

    public function slides()
    {
        return $this->hasMany(ShowroomSlide::class);
    }

    public function visitors()
    {
        return $this->hasMany(ShowroomVisitor::class);
    }
}
