<?php

namespace App\Repository\Eloquent;

use App\Models\Solution;


/**
 *
 */
class SolutionRepository extends BaseRepository
{

    /**
     * @param Solution $solution
     */
    public function __construct(Solution $solution)
    {
        parent::__construct($solution);
    }


}
