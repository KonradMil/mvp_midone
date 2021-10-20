<?php

namespace App\Services;

use App\Models\File;
use App\Models\Solution;
use App\Parameters\NewSolutionFilesParameters;
use App\Repository\Eloquent\FileRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


/**
 *
 */
class SolutionService
{
    public function __construct()
    {

    }

    /**
     * @param NewSolutionFilesParameters $solutionFilesParameters
     * @param Solution $solution
     * @return Model
     */
    public function addSolutionFiles(NewSolutionFilesParameters $solutionFilesParameters, Solution $solution): Model
    {
        $arrayFiles = $solutionFilesParameters->solutionFiles;
        $solutionFiles = $solution->files()->get();
        $arrayFilesId = [];

        if($solutionFiles){
            foreach($solutionFiles as $file) {
                $arrayFilesId[] = $file->id;
            }
        }

        foreach($arrayFiles as $arrayFile){
            $file = File::find($arrayFile['id']);

            if(!(in_array($arrayFile['id'], $arrayFilesId))){
                $solution->files()->attach($file);
            }
            $solution->files = $solution->files()->get();
            }

        return $solution;
    }

    /**
     * @param Solution $solution
     * @param File $file
     * @return mixed
     */
    public function detachFile(Solution $solution, File $file)
    {
        $solution->files()->detach($file);
    }
}
