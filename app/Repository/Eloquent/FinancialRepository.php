<?php

namespace App\Repository\Eloquent;

use App\Models\Financial;

/**
 *
 */
class FinancialRepository extends BaseRepository
{

    /**
     * @param Financial $financial
     */
    public function __construct(Financial $financial)
    {
        parent::__construct($financial);
    }
}
