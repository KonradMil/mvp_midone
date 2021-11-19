<?php

namespace App\Services\Admin;

use App\Parameters\Admin\PostParameters;
use App\Repository\Eloquent\Admin\PostRepository;

/**
 *
 */
class PostService
{
    public PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function saveSlide(PostParameters $postParameters, $id)
    {
//        $slide->name = $showroomParameters->name;
//        $slide->content = $showroomParameters->content;
//        $slide->type = $showroomParameters->type;
//        $slide->menu_name = $showroomParameters->menu_name;
//        $slide->showroom_id = $id;
//        $slide->save();
//
//        return $slide;
    }

}
