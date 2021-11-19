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
        $showroom->custom_functions = $showroomParameters->custom_functions;
        $showroom->description = $showroomParameters->description;
        $showroom->organization = $showroomParameters->organization;
        $showroom->organization_logo = $showroomParameters->organization_logo;
        $showroom->challenge_id = $showroomParameters->challenge_id;
        $showroom->dominant_color = $showroomParameters->dominant_color;
        $showroom->save();

        return $showroom;
    }

    public function saveShowroomSlide()
    {

    }

}
