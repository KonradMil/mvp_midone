<?php

namespace App\Repository\Eloquent;

use App\Models\Challenge;
use App\Models\FreeSave;
use App\Models\User;
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
     * @param FreeSave $freesave
     */
    public function __construct(FreeSave $freesave)
    {
        parent::__construct($freesave);
    }

    /**
     * @param User $user
     * @return Collection
     */
    public function getFreeSavesByUser(User $user): Collection
    {
        /** @var Collection|null $collection */

        return $freeSaves = $user->freesaves()->where('user_id', '=', $user->id)->get();
    }
}
