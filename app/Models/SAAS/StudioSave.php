<?php

namespace App\Models\SAAS;

use App\Models\Casts\JsonAsArrayObjectWithNull;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudioSave extends Model
{
    use HasFactory;

    protected $table = 'studio_saves';

    protected $fillable = [
      'save_json','screenshot'
    ];

    protected $casts = [
        'save_json' => JsonAsArrayObjectWithNull::class,
        'screenshot' => 'string'
    ];

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    public function author()
    {
        return $this->belongsTo(StudioUser::class);
    }
}
