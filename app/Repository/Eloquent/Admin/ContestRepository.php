<?php

namespace App\Repository\Eloquent\Admin;

use App\Models\Contests\Contest;
use App\Models\SAAS\Studio;
use App\Repository\Eloquent\BaseRepository;

/**
 *
 */
class ContestRepository extends BaseRepository
{

    /**
     * @param Contest $contest
     */
    public function __construct(Contest $contest = null)
    {
            parent::__construct($contest);
    }

}
