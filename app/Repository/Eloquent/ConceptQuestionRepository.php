<?php

namespace App\Repository\Eloquent;

use App\Models\ConceptQuestion;
use Illuminate\Database\Eloquent\Collection;

/**
 *
 */
class ConceptQuestionRepository extends BaseRepository
{

    /**
     * @param ConceptQuestion $conceptQuestion
     */
    public function __construct(ConceptQuestion $conceptQuestion)
    {
        parent::__construct($conceptQuestion);
    }

    /**
     * @param int $conceptId
     * @return Collection
     */
    public function getAllQuestionsByConceptId(int $conceptId): Collection
    {
        /** @var Collection|null $collection */

        return ConceptQuestion::where('project_concept_id', '=', $conceptId)->orderBy('created_at', 'DESC')->with('author')->with('answers')->get();
    }
}
