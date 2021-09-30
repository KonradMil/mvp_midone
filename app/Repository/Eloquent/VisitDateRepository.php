<?php

namespace App\Repository\Eloquent;

use App\Models\VisitDate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class VisitDateRepository extends BaseRepository
{

    /**
     * @param VisitDate $visitDate
     */
    public function __construct(VisitDate $visitDate)
    {
        parent::__construct($visitDate);
    }

    /**
     * @param int $projectId
     * @return Collection
     */
    public function getAllVisitDateByProjectId(int $projectId): Collection
    {
        /** @var Collection|null $collection */

        return VisitDate::where('project_id', '=', $projectId)->orderBy('accepted', 'ASC')
            ->orderBy('created_at', 'DESC')->with('author')->get(); // TODO: Change the autogenerated stub
    }
}
