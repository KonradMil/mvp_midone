<?php

namespace App\Models;

use App\Models\Challenges\Challenge;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public $table = 'questions';
    protected $fillable = [
        'question', 'answer',
        'author_id', 'challenge_id'
    ];

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
}
