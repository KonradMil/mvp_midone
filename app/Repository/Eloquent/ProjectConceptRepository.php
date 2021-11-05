<?php

namespace App\Repository\Eloquent;

use App\Models\ProjectConcept;
use Illuminate\Database\Eloquent\Collection;

/**
 *
 */
class ProjectConceptRepository extends BaseRepository
{

    /**
     * @param ProjectConcept $projectConcept
     */
    public function __construct(ProjectConcept $projectConcept)
    {
        parent::__construct($projectConcept);
    }

    /**
     * @param int $projectId
     * @param int $integratorId
     * @return Collection
     */
    public function getAllProjectConceptsByProject(int $projectId): Collection
    {
        /** @var Collection|null $collection */

        return ProjectConcept::where('project_id', '=', $projectId)->orderBy('created_at', 'DESC')
            ->with('author', 'files', 'questions')->get();
    }
}
