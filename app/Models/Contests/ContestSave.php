<?php

namespace App\Models\Contests;

use App\Models\Casts\JsonAsArrayObjectWithNull;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContestSave extends Model
{
    use HasFactory;

    protected $table = 'contest_saves';

    protected $fillable = [
      'save_json','screenshot'
    ];

    protected $casts = [
        'save_json' => JsonAsArrayObjectWithNull::class,
        'screenshot' => 'string'
    ];

    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

    public function author()
    {
        return $this->belongsTo(ContestUser::class);
    }
}
