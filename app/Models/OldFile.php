<?php

namespace App\Models;

use App\Modules\Dbr\Module\Models\Challenge;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldFile extends Model
{
    use HasFactory;
    public $table = 'aiods_files';
    protected $connection = 'old';

    protected $fillable = [
        'name', 'ext', 'original_name', 'path', 'thumbnail', 'size', 'alt', 'tags'
    ];

    protected $casts = [
        'tags' => 'array'
    ];


    public function challenge()
    {
        return $this->belongsTo(OldChallenge::class, 'file_id', 'challenge_id');
    }
}
