<?php

namespace App\Repository\Eloquent;

use App\Models\File;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;


/**
 *
 */
class FileRepository extends BaseRepository
{

    /**
     * @param File $file
     */
    public function __construct(File $file)
    {
        parent::__construct($file);
    }

    /**
     * @param Project $project
     * @return Collection
     */
    public function getFilesByProject(Project $project): Collection
    {
        return $project->files()->get();

    }
}
