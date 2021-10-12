<?php

namespace App\Repository\Eloquent;

use App\Models\Challenge;
use App\Models\FreeSave;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class FreeSavesRepository extends BaseRepository
{

    /**
     * @param Challenge $freesave
     */
    public function __construct(Challenge $freesave)
    {
        parent::__construct($freesave);
    }
}
