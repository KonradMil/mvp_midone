<?php

namespace App\Repository\Eloquent;

use App\Models\Company;

class CompanyRepository extends BaseRepository
{

    /**
     * @param Company $user
     */
    public function __construct(Company $user)
    {
        parent::__construct($user);
    }
}
