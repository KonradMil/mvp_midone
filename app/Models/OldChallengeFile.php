<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldChallengeFile extends Model
{
    use HasFactory;

    protected $connection = 'old';
    public $table = 'dbr_challenge_files';
    protected $fillable = [
        'type',
        'challenge_id', 'file_id'
    ];

    public function challenge()
    {
        return $this->belongsTo(OldChallenge::class);
    }

    public function file()
    {
        return $this->belongsTo(OldFile::class);
    }
}
