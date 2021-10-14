<?php

namespace App\Repository\Eloquent;

use App\Models\File;


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
}
