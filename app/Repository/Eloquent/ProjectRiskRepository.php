<?php

namespace App\Repository\Eloquent;

use App\Models\ProjectRisk;
use Illuminate\Database\Eloquent\Collection;


/**
 *
 */
class ProjectRiskRepository extends BaseRepository
{

    /**
     * @param ProjectRisk $projectRisk
     */
    public function __construct(ProjectRisk $projectRisk)
    {
        parent::__construct($projectRisk);
    }

    /**
     * @param int $projectId
     * @return Collection
     */
    public function getAllRisksByProjectId(int $projectId): Collection
    {
        /** @var Collection|null $collection */

        return ProjectRisk::where('project_id', '=', $projectId)->orderBy('created_at', 'DESC')->with('author')->get();
    }
}

