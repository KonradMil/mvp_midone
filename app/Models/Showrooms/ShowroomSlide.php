<?php

namespace App\Models\Showrooms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowroomSlide extends Model
{
    use HasFactory;

    protected $table = 'showroom_slide';

    protected $fillable = [
        'name',
        'content'
    ];

    public function showroom()
    {
        return $this->belongsTo(Showroom::class);
    }
}
