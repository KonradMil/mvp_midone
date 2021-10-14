<?php

namespace App\Services;

use App\Models\Financial;
use App\Models\FreeSave;
use App\Models\LocalVision;
use App\Models\Offer;
use App\Models\Project;
use App\Models\TechnicalDetails;
use App\Models\VisitDate;
use App\Parameters\NewFinancialParameters;
use App\Parameters\NewFreeSaveParameters;
use App\Parameters\NewLocalVisionCommentParameters;
use App\Parameters\NewLocalVisionParameters;
use App\Parameters\NewTechnicalDetailsParameters;
use App\Parameters\NewVisitDateMembersParameters;
use App\Repository\Eloquent\FreeSavesRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


/**
 *
 */
class FreeSaveService
{
    public function __construct()
    {

    }

    /**
     * @param NewFreeSaveParameters $newFreeSaveParameters
     * @param FreeSave $freeSave
     * @return Model
     */
    public function updateFreeSave(NewFreeSaveParameters $newFreeSaveParameters, FreeSave $freeSave): Model
    {
        $freeSave->name = $newFreeSaveParameters->name;
        $freeSave->en_name = $newFreeSaveParameters->en_name;
        $freeSave->description = $newFreeSaveParameters->description;
        $freeSave->en_description = $newFreeSaveParameters->en_description;
        $freeSave->save_json = $newFreeSaveParameters->save_json;

        $freeSave->save();

        return $freeSave;
    }


    /**
     * @param NewFreeSaveParameters $newFreeSaveParameters
     * @param FreeSavesRepository $freeSavesRepository
     * @return Model
     */
    public function addFreeSave(NewFreeSaveParameters $newFreeSaveParameters, FreeSavesRepository $freeSavesRepository): Model
    {
        $freeSaveParams = [
            'name' => $newFreeSaveParameters->name,
            'en_name' => $newFreeSaveParameters->en_name,
            'description' => $newFreeSaveParameters->description,
            'en_description' => $newFreeSaveParameters->en_description,
            'save_json' => $newFreeSaveParameters->save_json,
        ];

        $freeSave = $freeSavesRepository->create($freeSaveParams);

        return $freeSave;
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
     * @return Model
     */
    public function addLocalVision(NewLocalVisionParameters $newLocalVisionParameters): Model
    {

        $localVisionParams = [
            'author_id' => Auth::user()->id,
            'project_id' => $newLocalVisionParameters->projectId,
            'description' => $newLocalVisionParameters->description,
            'before' => $newLocalVisionParameters->before,
            'after' => $newLocalVisionParameters->after,
            'accepted' => $newLocalVisionParameters->accepted,
        ];

        $localVision = $this->localVisionRepository->create($localVisionParams);

        return $localVision;
    }

    /**
     * @param NewLocalVisionParameters $newLocalVisionParameters
     * @param LocalVision $localVision
     * @return Model
     */
    public function updateLocalVision(NewLocalVisionParameters $newLocalVisionParameters, LocalVision $localVision): Model
    {
        $localVision->description = $newLocalVisionParameters->description;
        $localVision->before = $newLocalVisionParameters->before;
        $localVision->after = $newLocalVisionParameters->after;

        $localVision->save();

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
     * @return Project
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
            'challenge_id' => $newTechnicalDetailsParameters->challengeId,
            'detail_weight' => $newTechnicalDetailsParameters->detailWeight,
            'pick_quality' => $newTechnicalDetailsParameters->pickQuality,
            'detail_material' => $newTechnicalDetailsParameters->detailMaterial,
            'detail_size' => $newTechnicalDetailsParameters->detailSize,
            'detail_pick' => $newTechnicalDetailsParameters->detailPick,
            'detail_position' => $newTechnicalDetailsParameters->detailPosition,
            'detail_range' => $newTechnicalDetailsParameters->detailRange,
            'detail_destination' => $newTechnicalDetailsParameters->detailDestination,
            'number_of_lines' => $newTechnicalDetailsParameters->numberOfLines,
            'work_shifts' => $newTechnicalDetailsParameters->workShifts,
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
            'challenge_id' => $newFinancialParameters->challengeId,
            'days' => $newFinancialParameters->days,
            'shifts' => $newFinancialParameters->shifts,
            'shift_time' => $newFinancialParameters->shiftTime,
            'weekend_shift' => $newFinancialParameters->weekendShift,
            'breakfast' => $newFinancialParameters->breakfast,
            'stop_time' => $newFinancialParameters->stopTime,
            'operator_performance' => $newFinancialParameters->operatorPerformance,
            'defective' => $newFinancialParameters->defective,
            'number_of_operators' => $newFinancialParameters->numberOfOperators,
            'operator_cost' => $newFinancialParameters->operatorCost,
            'absence' => $newFinancialParameters->absence,
            'cycle_time' => $newFinancialParameters->cycleTime,
        ];
        /** @var Financial $financial */

        $financial = $this->financialRepository->create($financialParams);

        return $financial;
    }

    /**
     * @param Project $project
     * @return Project
     */
    public function acceptTechnicalDetails(Project $project): Project
    {
        $project->accept_technical_details = 1;
        $project->save();

        return $project;
    }

    /**
     * @param Project $project
     * @return Project
     */
    public function rejectTechnicalDetails(Project $project): Project
    {
        $project->accept_technical_details = 2;
        $project->save();

        return $project;
    }

    /**
     * @param Project $project
     * @return Project
     */
    public function acceptFinancialDetails(Project $project): Project
    {
        $project->accept_financial_details = 1;
        $project->save();

        return $project;
    }

    /**
     * @param Project $project
     * @return Project
     */
    public function rejectFinancialDetails(Project $project): Project
    {
        $project->accept_financial_details = 2;
        $project->save();

        return $project;
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
