<?php

namespace App\Repository\Eloquent\Admin;

use App\Models\Showrooms\Showroom;
use App\Repository\Eloquent\BaseRepository;

/**
 *
 */
class ShowroomRepository extends BaseRepository
{

    /**
     * @param Showroom $showroom
     */
    public function __construct(Showroom $showroom = null)
    {
            parent::__construct($showroom);
    }

    /**
     * @param int $id
     * @return Showroom
     */
    public function getFullShowroomById(int $id): Showroom
    {
        $showroom = Showroom::with('visitors', 'slides')->find($id);

        return $showroom;
    }

}
