<?php

namespace App\Http\Requests\Handlers\Admin;

use App\Http\Requests\Handlers\RequestHandler;
use App\Parameters\Admin\DiscussionParameters;
use App\Parameters\Admin\PostParameters;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class DiscussionHandler extends RequestHandler
{

    /**
     * @return DiscussionParameters
     */
    public function getParameters(): DiscussionParameters
    {
        $parameters = new DiscussionParameters();
        $discussion = $this->request->get('discussion');
        $parameters->title = $discussion['title'];
        $parameters->body = $discussion['body'];
        $parameters->slug = $discussion['slug'] ?? strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $discussion['title'])));;
        $parameters->color = $discussion['color'] ?? '';
        $parameters->sticky = $discussion['sticky'] ?? 0;
        $parameters->category_id = $discussion['category_id'];
        $parameters->user_id = Auth::user()->id;

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
