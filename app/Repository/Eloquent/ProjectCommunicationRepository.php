<?php

namespace App\Repository\Eloquent;

use App\Models\ProjectCommunication;
use Illuminate\Database\Eloquent\Collection;


/**
 *
 */
class ProjectCommunicationRepository extends BaseRepository
{

    /**
     * @param ProjectCommunication $projectCommunication
     */
    public function __construct(ProjectCommunication $projectCommunication)
    {
        parent::__construct($projectCommunication);
    }

    /**
     * @param int $projectId
     * @param int $integratorId
     * @return Collection
     */
    public function getAllIntegratorCommunicationsByProjectId(int $projectId, int $integratorId): Collection
    {
        /** @var Collection|null $collection */

        return ProjectCommunication::where('project_id', '=', $projectId)->where('author_id', '=', $integratorId)->orderBy('created_at', 'DESC')->with('author')->get();
    }

    /**
     * @param int $projectId
     * @param int $investorId
     * @return Collection
     */
    public function getAllInvestorCommunicationsByProjectId(int $projectId, int $investorId): Collection
    {
        /** @var Collection|null $collection */

        return ProjectCommunication::where('project_id', '=', $projectId)->where('author_id', '=', $investorId)->orderBy('created_at', 'DESC')->with('author')->get();
    }
}
