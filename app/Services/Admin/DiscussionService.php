<?php

namespace App\Services\Admin;

use App\Parameters\Admin\DiscussionParameters;
use App\Parameters\Admin\PostParameters;
use App\Repository\Eloquent\Admin\PostRepository;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class DiscussionService
{
    public DiscussionParameters $discussionParameters;

    public function __construct(DiscussionParameters $discussionParameters)
    {
        $this->discussionParameters = $discussionParameters;
    }

    public function saveDiscussion(DiscussionParameters $discussionParameters, $discussion, $post)
    {
        $discussion->title = $discussionParameters->title;
        $discussion->category_id = $discussionParameters->category_id;
        $discussion->color = $discussionParameters->color;
        $discussion->slug = $discussionParameters->slug;
        $discussion->user_id = Auth::user()->id;
        $discussion->save();

        $post->discussion_id = $discussion->id;
        $post->user_id = Auth::user()->id;
        $post->body = $discussionParameters->body;
        $post->save();

        return $discussion;
    }

}
