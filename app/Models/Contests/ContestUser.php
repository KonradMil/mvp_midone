<?php

namespace App\Models\Contests;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContestUser extends Model
{
    use HasFactory;

    protected $fillable = [
      'email', 'password', 'contest_id'
    ];

    public function contest () {
        return $this->belongsTo(Contest::class, 'contest_id');
    }

    public function saves()
    {
        return $this->hasMany(ContestSave::class);
    }
}
