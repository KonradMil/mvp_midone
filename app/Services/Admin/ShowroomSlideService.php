<?php

namespace App\Services\Admin;

use App\Models\Showrooms\Showroom;
use App\Models\Showrooms\ShowroomSlide;
use App\Parameters\Admin\ShowroomParameters;
use App\Parameters\Admin\ShowroomSlideParameters;
use App\Repository\Eloquent\Admin\ShowroomRepository;
use App\Repository\Eloquent\Admin\ShowroomSlideRepository;

/**
 *
 */
class ShowroomSlideService
{
    public ShowroomSlideRepository $showroomSlideRepository;

    public function __construct(ShowroomSlideRepository $showroomSlideRepository)
    {
        $this->showroomSlideRepository = $showroomSlideRepository;
    }

    public function saveSlide(ShowroomSlideParameters $showroomParameters, ShowroomSlide $slide, $id)
    {
        $slide->name = $showroomParameters->name;
        $slide->content = $showroomParameters->content;
        $slide->type = $showroomParameters->type;
        $slide->menu_name = $showroomParameters->menu_name;
        $slide->showroom_id = $id;
        $slide->save();

        return $slide;
    }

}
