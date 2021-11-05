<?php

namespace App\Models\Contests;

use App\Models\Contests\ContestTaskFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContestTask extends Model
{
    use HasFactory;

    protected $table = 'contest_tasks';

    protected $fillable = [
        'name', 'content'
    ];

    public function files()
    {
        return $this->hasMany(ContestTaskFile::class);
    }

    public function contest()
    {
        return $this->belongsTo(Contest::class, 'contest_id');
    }
}
