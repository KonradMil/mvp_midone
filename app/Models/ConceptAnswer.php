<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConceptAnswer extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    public $table = 'concept_answers';

    /**
     * @var string[]
     */
    protected $fillable = [
        'answer', 'author_id', 'concept_question_id'
    ];

    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function concept_question(): BelongsTo
    {
        return $this->belongsTo(ConceptQuestion::class);
    }
}
