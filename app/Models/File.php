<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $table = 'files';

    protected $fillable = [
        'name', 'ext', 'original_name', 'path', 'thumbnail', 'size', 'alt', 'tags'
    ];

    protected $casts = [
        'tags' => 'array'
    ];
}
