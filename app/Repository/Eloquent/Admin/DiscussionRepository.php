<?php

namespace App\Repository\Eloquent\Admin;

use App\Models\Forum\Discussion;
use App\Models\Forum\Post;
use App\Repository\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

/**
 *
 */
class DiscussionRepository extends BaseRepository
{

    /**
     * @param Discussion $discussion
     */
    public function __construct(Discussion $discussion = null)
    {
            parent::__construct($discussion);
    }

    public function all() : Collection
    {
        return Discussion::with('user', 'category')->get();
    }

}
