<?php

namespace App\Http\Requests\Handlers\Admin;

use App\Http\Requests\Handlers\RequestHandler;
use App\Parameters\Admin\ShowroomSlideParameters;

/**
 *
 */
class ShowroomSlideHandler extends RequestHandler
{

    /**
     * @return ShowroomSlideParameters
     */
    public function getParameters(): ShowroomSlideParameters
    {
        $parameters = new ShowroomSlideParameters();

        $parameters->name = $slide['title'] ?? '';
        $parameters->menu_name = '';
        $parameters->menu_name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $slide['title'])));
        $parameters->content = $slide['content'] ?? $slide['text'];
        $parameters->type = $slide['type'] ?? 0;

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
