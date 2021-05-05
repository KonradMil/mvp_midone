<?php

namespace App\Models;

use App\Models\Reports\Report;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $table = 'files';

    protected $fillable = [
        'name', 'ext', 'original_name', 'path', 'thumbnail', 'size', 'alt', 'tags', 'author_id'
    ];

    protected $casts = [
        'tags' => 'array'
    ];

    public function reports(){
        return $this->belongsToMany(Report::class);
    }
    public function author() {
        return $this->hasMany(User::class);
    }
}
