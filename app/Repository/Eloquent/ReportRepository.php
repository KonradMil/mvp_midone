<?php

namespace App\Repository\Eloquent;

use App\Models\File;
use App\Models\Report;


/**
 *
 */
class ReportRepository extends BaseRepository
{

    /**
     * @param Report $report
     */
    public function __construct(Report $report)
    {
        parent::__construct($report);
    }

    public function getAllReports()
    {
        return Report::where('id', '!=', null)->with('author')->get();
    }
}
