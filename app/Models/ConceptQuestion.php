<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConceptQuestion extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    public $table = 'concept_questions';

    /**
     * @var string[]
     */
    protected $fillable = [
        'question', 'answer', 'accepted', 'author_id', 'project_concept_id'
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
    public function project_concept(): BelongsTo
    {
        return $this->belongsTo(ProjectConcept::class);
    }

    /**
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(ConceptAnswer::class, 'concept_question_id');
    }
}
