<?php

namespace App\Repository\Eloquent\Admin;

use App\Models\SAAS\Studio;
use App\Repository\Eloquent\BaseRepository;

/**
 *
 */
class SAASRepository extends BaseRepository
{

    /**
     * @param Studio $saas
     */
    public function __construct(Studio $saas = null)
    {
            parent::__construct($saas);
    }

}
