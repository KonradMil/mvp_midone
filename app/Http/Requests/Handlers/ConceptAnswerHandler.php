<?php

namespace App\Http\Requests\Handlers;

use App\Parameters\NewConceptAnswerParameters;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class ConceptAnswerHandler extends RequestHandler
{

    /**
     * @return NewConceptAnswerParameters
     */
    public function getParameters(): NewConceptAnswerParameters
    {
        $parameters = new NewConceptAnswerParameters();
        $parameters->authorId = Auth::user()->id;
        $parameters->conceptQuestionId = $this->request->get('concept_question_id');
        $parameters->answer = $this->request->get('answer');

        return $parameters;
    }

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
