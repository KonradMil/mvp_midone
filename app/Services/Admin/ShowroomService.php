<?php

namespace App\Services\Admin;

use App\Models\Showrooms\Showroom;
use App\Parameters\Admin\ShowroomParameters;
use App\Repository\Eloquent\Admin\ShowroomRepository;

/**
 *
 */
class ShowroomService
{
    public ShowroomRepository $showroomRepository;

    public function __construct(ShowroomRepository $showroomRepository)
    {
        $this->showroomRepository = $showroomRepository;
    }

    public function saveShowroom(ShowroomParameters $showroomParameters, Showroom $showroom)
    {
        $showroom->name = $showroomParameters->name;
        $showroom->custom_css = $showroomParameters->custom_css;
        $showroom->challenge_id = $showroomParameters->challenge_id;
        $showroom->save();

        return $showroom;
    }

    public function saveShowroomSlide()
    {

    }

}
