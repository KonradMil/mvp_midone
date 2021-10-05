<?php

namespace App\Http\Requests\Handlers;

use App\Parameters\NewLocalVisionCommentParameters;
use App\Parameters\NewLocalVisionParameters;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class LocalVisionHandler extends RequestHandler
{

    /**
     * @return NewLocalVisionParameters
     */
    public function getParameters(): NewLocalVisionParameters
    {
        $parameters = new NewLocalVisionParameters();
        $parameters->authorId = Auth::user()->id;
        $parameters->projectId = (int)$this->request->route()->parameter('project_id');
        $parameters->reportId = $this->request->get('report_id');
        $parameters->description = $this->request->get('description');
        $parameters->before = $this->request->get('before');
        $parameters->after = $this->request->get('after');
        $parameters->accepted = $this->request->get('accepted');

        return $parameters;
    }

    /**
     * @return NewLocalVisionCommentParameters
     */
    public function getCommentParameters(): NewLocalVisionCommentParameters
    {
        $parameters = new NewLocalVisionCommentParameters();
        $parameters->comment = $this->request->get('comment');

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
