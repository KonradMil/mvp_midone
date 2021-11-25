<?php

namespace App\Models\Contests;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    use HasFactory;

    protected $table = 'contests';

    protected $fillable = [
      'name', 'name_slug', 'organization_name', 'max_users'
    ];

    public function tasks()
    {
        return $this->hasMany(Contest::class);
    }
}
