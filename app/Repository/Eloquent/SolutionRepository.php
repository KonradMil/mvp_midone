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

    /**
     * @param int $id
     * @return mixed
     */
    public function getSolutionWithFiles(int $id)
    {
        return Solution::where('id','=', $id)->with('files')->first();
    }

}
