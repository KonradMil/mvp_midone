<?php

namespace App\Http\Requests\Handlers;

use App\Http\Controllers\S3Controller;
use App\Parameters\NewFreeSaveParameters;
use App\Parameters\NewLocalVisionCommentParameters;
use App\Parameters\NewLocalVisionParameters;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class FreeSavesHandler extends RequestHandler
{

    /**
     * @return NewFreeSaveParameters
     */
    public function getParameters(): NewFreeSaveParameters
    {
        $parameters = new NewFreeSaveParameters();
        $parameters->name = $this->request->get('name');
        $parameters->en_name = $this->request->get('en_name');
        $parameters->description = $this->request->get('description');
        $parameters->en_description = $this->request->get('en_description');
        $save =  json_decode($this->request->get('save'), true);
        $img = S3Controller::processScreenshot($save['screenshot']);
        unset($save['screenshot']);
        $parameters->save_json = json_encode($save);
        dd($img);
        $parameters->screenshot_path = $img['relative'];

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
