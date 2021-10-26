<?php

namespace App\Repository\Eloquent;

use App\Models\ConceptAnswer;

/**
 *
 */
class ConceptAnswerRepository extends BaseRepository
{

    /**
     * @param ConceptAnswer $conceptAnswer
     */
    public function __construct(ConceptAnswer $conceptAnswer)
    {
        parent::__construct($conceptAnswer);
    }
}
