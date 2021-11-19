<?php

namespace App\Services\Admin;

use App\Models\SAAS\Studio;
use App\Parameters\Admin\SAASParameters;
use App\Repository\Eloquent\Admin\SAASRepository;

/**
 *
 */
class SAASService
{
    public SAASRepository $SAASRepository;

    public function __construct(SAASRepository $SAASRepository)
    {
        $this->SAASRepository = $SAASRepository;
    }

    public function saveService(SAASParameters $SAASParameters, Studio $studio)
    {
        $studio->name = $SAASParameters->name;
        $studio->organization_name = $SAASParameters->organization_name;
        $studio->organization_logo = $SAASParameters->organization_logo;
        $studio->organization_slug = $SAASParameters->organization_slug;
        $studio->email_regexp = $SAASParameters->email_regexp;
        $studio->max_users = $SAASParameters->max_users;
        $studio->paid = $SAASParameters->paid;
        $studio->save();

        return $studio;
    }

}
