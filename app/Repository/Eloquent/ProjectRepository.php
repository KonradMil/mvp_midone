<?php

namespace App\Repository\Eloquent;

use App\Models\Offer;
use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class ProjectRepository extends BaseRepository
{

    /**
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        parent::__construct($project);
    }

    /**
     * @param int $challengeId
     * @return Builder|array|Collection|Model
     */
    public function getProjectByChallengeId(int $challengeId): Builder|array|Collection|Model
    {
        /** @var Project|null $project */
        $project = Project::where('challenge_id', '=', $challengeId)->first();

        return $project;
    }

    /**
     * @param Project $project
     * @return Collection
     */
    public function getProjectOffers(Project $project): Collection
    {
        $offers = Offer::where('project_id', '=', $project->id)->orderBy('is_offer_project', 'ASC')->orderBy('created_at', 'DESC')->with('solution')->get();

        return $offers;
    }
}
