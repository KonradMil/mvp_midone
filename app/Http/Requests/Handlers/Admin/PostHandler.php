<?php

namespace App\Http\Requests\Handlers\Admin;

use App\Http\Requests\Handlers\RequestHandler;
use App\Parameters\Admin\PostParameters;

/**
 *
 */
class PostHandler extends RequestHandler
{

    /**
     * @return PostParameters
     */
    public function getParameters(): PostParameters
    {
        $parameters = new PostParameters();
        $post = $this->request->get('post');
        $parameters->body = $post['body'];
        $parameters->markdown = $post['markdown'];
        $parameters->discussion_id = $post['discussion_id'];

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
