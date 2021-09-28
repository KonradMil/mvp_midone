<?php

namespace App\Services;


use App\Models\Challenge;
use App\Models\Financial;
use App\Models\LocalVision;
use App\Models\Offer;
use App\Models\Project;
use App\Models\TechnicalDetails;
use App\Models\VisitDate;
use App\Parameters\FinancialParameters;
use App\Parameters\NewFinancialParameters;
use App\Parameters\NewLocalVisionCommentParameters;
use App\Parameters\NewLocalVisionParameters;
use App\Parameters\NewTechnicalDetailsParameters;
use App\Parameters\NewVisitDateMembersParameters;
use App\Parameters\NewVisitDateParameters;
use App\Repository\Eloquent\ChallengeRepository;
use App\Repository\Eloquent\FinancialRepository;
use App\Repository\Eloquent\LocalVisionRepository;
use App\Repository\Eloquent\TechnicalDetailsRepository;
use App\Repository\Eloquent\VisitDateRepository;
use Illuminate\Support\Facades\Auth;


/**
 *
 */
class ProjectService
{
    /**
     * @var TechnicalDetailsRepository
     */
    private TechnicalDetailsRepository $technicalDetailsRepository;
    /**
     * @var FinancialRepository
     */
    private FinancialRepository $financialRepository;
    /**
     * @var LocalVisionRepository
     */
    private LocalVisionRepository $localVisionRepository;

    /**
     * @var VisitDateRepository
     */
    private VisitDateRepository $visitDateRepository;

    private ChallengeRepository $challengeRepository;

    public function __construct(ChallengeRepository $challengeRepository, VisitDateRepository $visitDateRepository, LocalVisionRepository $localVisionRepository, TechnicalDetailsRepository $technicalDetailsRepository, FinancialRepository $financialRepository)
    {
        $this->challengeRepository = $challengeRepository;
        $this->visitDateRepository = $visitDateRepository;
        $this->localVisionRepository = $localVisionRepository;
        $this->technicalDetailsRepository = $technicalDetailsRepository;
        $this->financialRepository = $financialRepository;
    }

    public function getChallengeById(int $id): ?Challenge
    {
        /** @var Challenge|null $challenge */
        $challenge = $this->challengeRepository->getFullChallengeById($id);

        if (!$challenge) {
            return $challenge;
        }

        $challenge->selected = $challenge->solutions()->where('selected', '=', 1)->get();

        if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge, 'Like', 1)) {
            $challenge->liked = true;
        } else {
            $challenge->liked = false;
        }

        if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge, 'Follow', 1)) {
            $challenge->followed = true;
        } else {
            $challenge->followed = false;
        }

        foreach ($challenge->solutions as $sol) {
            if (Auth::user()->viaLoveReacter()->hasReactedTo($sol, 'Like', 1)) {
                $sol->liked = true;
            } else {
                $sol->liked = false;
            }

            if (Auth::user()->viaLoveReacter()->hasReactedTo($sol, 'Follow', 1)) {
                $sol->followed = true;
            } else {
                $sol->followed = false;
            }
            $sol->comments_count = $sol->comments()->count();
            $sol->likes = $sol->viaLoveReactant()->getReactionCounterOfType('Like')->getCount();
        }

        $challenge->comments_count = $challenge->comments()->count();
        $challenge->likes = $challenge->viaLoveReactant()->getReactionCounterOfType('Like')->getCount();

        return $challenge;
    }

    /**
     * @param NewVisitDateParameters $newVisitDateParameters
     * @return VisitDate
     */
    public function addVisitDate(NewVisitDateParameters $newVisitDateParameters): VisitDate
    {

        $visitDateParams = [
            'author_id' => Auth::user()->id,
            'project_id' => $newVisitDateParameters->project_id,
            'date' => $newVisitDateParameters->date,
            'time' => $newVisitDateParameters->time
        ];
        /** @var VisitDate $visitDate */

        $visitDate = $this->visitDateRepository->create($visitDateParams);

        return $visitDate;
    }

    /**
     * @param NewVisitDateMembersParameters $newVisitDateMembersParameters
     * @param VisitDate $visitDate
     * @return VisitDate
     */
    public function addMembersVisitDate(NewVisitDateMembersParameters $newVisitDateMembersParameters, VisitDate $visitDate): VisitDate
    {
        $visitDate->members = $newVisitDateMembersParameters->members;
        $visitDate->save();

        /** @var VisitDate $visitDate */
        return $visitDate;
    }

    /**
     * @param VisitDate $visitDate
     * @return VisitDate
     */
    public function acceptVisitDate(VisitDate $visitDate): VisitDate
    {
        $visitDate->accepted = 1;
        $visitDate->save();

        /** @var VisitDate $visitDate */
        return $visitDate;
    }

    /**
     * @param VisitDate $visitDate
     * @return VisitDate
     */
    public function rejectVisitDate(VisitDate $visitDate): VisitDate
    {
        $visitDate->accepted = 2;
        $visitDate->save();

        /** @var VisitDate $visitDate */
        return $visitDate;
    }

    /**
     * @param VisitDate $visitDate
     * @return VisitDate
     */
    public function cancelVisitDate(VisitDate $visitDate): VisitDate
    {
        $visitDate->status = 1;
        $visitDate->save();

        /** @var VisitDate $visitDate */
        return $visitDate;
    }

    /**
     * @param VisitDate $visitDate
     */
    public function deleteVisitDate(VisitDate $visitDate)
    {
        $visitDate->delete();
    }

    /**
     * @param NewLocalVisionParameters $newLocalVisionParameters
     * @return LocalVision
     */
    public function addLocalVision(NewLocalVisionParameters $newLocalVisionParameters): LocalVision
    {

        $localVisionParams = [
            'author_id' => Auth::user()->id,
            'project_id' => $newLocalVisionParameters->project_id,
            'description' => $newLocalVisionParameters->description,
            'before' => $newLocalVisionParameters->before,
            'after' => $newLocalVisionParameters->after,
            'accepted' => $newLocalVisionParameters->accepted,
        ];
        /** @var LocalVision $localVision */

        $localVision = $this->localVisionRepository->create($localVisionParams);

        return $localVision;
    }

    /**
     * @param LocalVision $localVision
     * @return LocalVision
     */
    public function acceptReport(LocalVision $localVision): LocalVision
    {
        $localVision->accepted = 1;
        $localVision->save();

        /** @var LocalVision $localVision */
        return $localVision;
    }

    /**
     * @param LocalVision $localVision
     * @return LocalVision
     */
    public function rejectReport(LocalVision $localVision): LocalVision
    {
        $localVision->accepted = 2;
        $localVision->save();

        /** @var LocalVision $localVision */
        return $localVision;
    }

    /**
     * @param LocalVision $localVision
     */
    public function deleteReport(LocalVision $localVision)
    {
        $localVision->delete();
    }

    /**
     * @param Project $project
     */
    public function endLocalVision(Project $project): Project
    {
        $project->accept_local_vision = 1;
        $project->save();

        return $project;
    }

    /**
     * @param NewLocalVisionCommentParameters $newLocalVisionCommentParameters
     * @param LocalVision $localVision
     * @return LocalVision
     */
    public function addCommentLocalVision(NewLocalVisionCommentParameters $newLocalVisionCommentParameters, LocalVision $localVision): LocalVision
    {
        $localVision->comment = $newLocalVisionCommentParameters->comment;
        $localVision->save();

        /** @var LocalVision $localVision */
        return $localVision;
    }

    /**
     * @param $projectId
     * @return bool
     */
    public function checkLocalVision($projectId): bool
    {
        $check = true;
        $localVisions = LocalVision::where('project_id', '=', $projectId)->get();
        $visitDates = VisitDate::where('project_id', '=', $projectId)->get();
        foreach ($localVisions as $localVision) {
            if ($localVision->accepted == 0) {
                $check = false;
            }
        }
        foreach ($visitDates as $visitDate) {
            if ($visitDate->accepted == 0) {
                $check = false;
            }
        }

        return $check;
    }

    /**
     * @param NewTechnicalDetailsParameters $newTechnicalDetailsParameters
     * @return TechnicalDetails
     */
    public function addTechnicalDetails(NewTechnicalDetailsParameters $newTechnicalDetailsParameters): TechnicalDetails
    {
        $technicalDetailsParams = [
            'challenge_id' => $newTechnicalDetailsParameters->challenge_id,
            'detail_weight' => $newTechnicalDetailsParameters->detail_weight,
            'pick_quality' => $newTechnicalDetailsParameters->pick_quality,
            'detail_material' => $newTechnicalDetailsParameters->detail_material,
            'detail_size' => $newTechnicalDetailsParameters->detail_size,
            'detail_pick' => $newTechnicalDetailsParameters->detail_pick,
            'detail_position' => $newTechnicalDetailsParameters->detail_position,
            'detail_range' => $newTechnicalDetailsParameters->detail_range,
            'detail_destination' => $newTechnicalDetailsParameters->detail_destination,
            'number_of_lines' => $newTechnicalDetailsParameters->number_of_lines,
            'work_shifts' => $newTechnicalDetailsParameters->work_shifts,
        ];
        /** @var TechnicalDetails $technicalDetails */

        $technicalDetails = $this->technicalDetailsRepository->create($technicalDetailsParams);

        return $technicalDetails;
    }

    /**
     * @param NewFinancialParameters $newFinancialParameters
     * @return Financial
     */
    public function addFinancialDetails(NewFinancialParameters $newFinancialParameters): Financial
    {
        $financialParams = [
            'challenge_id' => $newFinancialParameters->challenge_id,
            'days' => $newFinancialParameters->days,
            'shifts' => $newFinancialParameters->shifts,
            'shift_time' => $newFinancialParameters->shift_time,
            'weekend_shift' => $newFinancialParameters->weekend_shift,
            'breakfast' => $newFinancialParameters->breakfast,
            'stop_time' => $newFinancialParameters->stop_time,
            'operator_performance' => $newFinancialParameters->operator_performance,
            'defective' => $newFinancialParameters->defective,
            'number_of_operators' => $newFinancialParameters->number_of_operators,
            'operator_cost' => $newFinancialParameters->operator_cost,
            'absence' => $newFinancialParameters->absence,
            'cycle_time' => $newFinancialParameters->cycle_time,
        ];
        /** @var Financial $financial */

        $financial = $this->financialRepository->create($financialParams);

        return $financial;
    }

    /**
     * @param Project $project
     */
    public function acceptTechnicalDetails(Project $project): Project
    {
        $project->accept_technical_details = 1;
        $project->save();

        return $project;
    }

    /**
     * @param Project $project
     */
    public function rejectTechnicalDetails(Project $project): Project
    {
        $project->accept_technical_details = 2;
        $project->save();

        return $project;
    }

    /**
     * @param Project $project
     */
    public function acceptFinancialDetails(Project $project): Project
    {
        $project->accept_financial_details = 1;
        $project->save();

        return $project;
    }

    /**
     * @param Project $project
     */
    public function rejectFinancialDetails(Project $project): Project
    {
        $project->accept_financial_details = 2;
        $project->save();

        return $project;
    }

    /**
     * @param Project $project
     */
    public function getSelectedOfferByProject(Project $project): ?Offer
    {
        $offer = null;
        if ($project->selected_offer_id > 0) {
            $offer = Offer::find($project->selected_offer_id)->with('solution');
        }

        return $offer;
    }

    /**
     * @param Project $project
     * @param Offer $offer
     * @return Project
     */
    public function acceptOffer(Project $project, Offer $offer): Project
    {
        $offer->is_offer_project = 1;
        $project->accept_offer = 1;
        $offer->save();
        $project->save();

        return $project;
    }

    /**
     * @param Project $project
     * @param Offer $offer
     * @param string $feedback
     * @return Project
     */
    public function rejectOffer(Project $project, Offer $offer, string $feedback): Project
    {
        $offer->is_offer_project = 2;
        $offer->comment = $feedback;
        $project->selected_offer_id = 0;
        $project->accept_offer = 2;
        $offer->save();
        $project->save();

        return $project;
    }
}
