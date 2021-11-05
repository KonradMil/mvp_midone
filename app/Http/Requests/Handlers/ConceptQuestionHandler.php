<?php

namespace App\Http\Requests\Handlers;

use App\Parameters\NewConceptQuestionParameters;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class ConceptQuestionHandler extends RequestHandler
{

    /**
     * @return NewConceptQuestionParameters
     */
    public function getParameters(): NewConceptQuestionParameters
    {
        $parameters = new NewConceptQuestionParameters();
        $parameters->authorId = Auth::user()->id;
        $parameters->conceptId = $this->request->get('concept_id');
        $parameters->question = $this->request->get('question');

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
