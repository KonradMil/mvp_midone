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
class FreeSavesService
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
     * @param FreeSave $freeSave
     */
    public function deleteFreeSave(FreeSave $freeSave)
    {
        $freeSave->delete();
    }
}
