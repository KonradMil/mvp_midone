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
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


/**
 *
 */
class FreeSavesService
{
    public FreeSavesRepository $freeSavesRepository;

    public function __construct(FreeSavesRepository $freeSavesRepository)
    {
        $this->freeSavesRepository = $freeSavesRepository;
    }

    public function createEmptySave()
    {
        $freeSave = new FreeSave();
        $freeSave->save_json = '{"parts":[],"animation_layers":{"layers":[],"groups":[]},"layouts":{"layouts":[],"labels":[],"comments":[],"robotTrackers":[]},"presentationModel":{"cameraStations":[]},"hangarModel":{"name":"","id":0,"prefabUrl":"","customData":"","limits":{"maxLimits":{"x":0.0,"y":0.0,"z":0.0},"minLimits":{"x":0.0,"y":0.0,"z":0.0}}},"cameraPosition":{"position":{"x":0.0,"y":0.0,"z":0.0},"rotation":{"x":0.0,"y":0.0,"z":0.0}},"screenshot":"","saveVersion":""}';
        $freeSave->name = 'Zapis ' . Carbon::now()->format('d.m.Y H:i');
        $freeSave->save();

        $freeSave->users()->attach(Auth::user()->id, ['is_owner' => 1]);

        return $freeSave->id;
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
        $freeSave->screenshot_path = $newFreeSaveParameters->screenshot_path;

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
