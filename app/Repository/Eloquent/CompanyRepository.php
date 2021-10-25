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

    public function findByAuthorId($authorId)
    {
        return Company::where('author_id', '=', $authorId)->first();
    }
}
