<?php

namespace App\Repository\Eloquent;

use App\Models\TechnicalDetails;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class TechnicalDetailsRepository extends BaseRepository
{

    /**
     * @param TechnicalDetails $technicalDetails
     */
    public function __construct(TechnicalDetails $technicalDetails)
    {
        parent::__construct($technicalDetails);
    }
}
