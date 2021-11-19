<?php

namespace App\Repository\Eloquent\Admin;

use App\Models\Forum\Post;
use App\Repository\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

/**
 *
 */
class PostRepository extends BaseRepository
{

    /**
     * @param Post $post
     */
    public function __construct(Post $post = null)
    {
            parent::__construct($post);
    }

    public function all() : Collection
    {
        return Post::with('user')->get();
    }

}
