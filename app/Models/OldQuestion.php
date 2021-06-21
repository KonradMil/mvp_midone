<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldQuestion extends Model
{
    public $table = 'dbr_questions';
    protected $connection = 'old';
    protected $fillable = [
        'question', 'answer',
        'author_id', 'challenge_id'
    ];

    public function author()
    {
        return $this->belongsTo(OldUser::class);
    }

    public function challenge()
    {
        return $this->belongsTo(OldChallenge::class);
    }
}
