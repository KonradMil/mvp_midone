<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProjectConcept extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    public $table = 'project_concepts';

    /**
     * @var string[]
     */
    protected $fillable = [
        'title', 'description', 'accepted', 'author_id', 'project_id'
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
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @return BelongsToMany
     */
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'project_concept_questions', 'project_concept_id', 'question_id');
    }

    /**
     * @return BelongsToMany
     */
    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class, 'project_concept_files', 'project_concept_id', 'file_id');
    }
}
