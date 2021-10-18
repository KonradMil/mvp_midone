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
     * @return Collection
     */
    public function getAllCommunicationsByProjectId(int $projectId): Collection
    {
        /** @var Collection|null $collection */

        return ProjectCommunication::where('project_id', '=', $projectId)->orderBy('created_at', 'DESC')->with('author')->get();
    }
}
