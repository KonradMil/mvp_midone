<?php

namespace App\Models\Showrooms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowroomVisitor extends Model
{
    use HasFactory;

    protected $table = 'showroom_visitor';

    protected $fillable = [
      'email'
    ];

    public function showroom()
    {
        return $this->belongsTo(Showroom::class, 'showroom_id');
    }
}
