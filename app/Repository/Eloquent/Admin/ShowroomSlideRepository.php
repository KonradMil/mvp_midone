<?php

namespace App\Repository\Eloquent\Admin;

use App\Models\Showrooms\ShowroomSlide;
use App\Repository\Eloquent\BaseRepository;

/**
 *
 */
class ShowroomSlideRepository extends BaseRepository
{

    /**
     * @param ShowroomSlide $slide
     */
    public function __construct(ShowroomSlide $slide = null)
    {
            parent::__construct($slide);
    }

}
