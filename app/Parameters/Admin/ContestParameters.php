<?php

namespace App\Parameters\Admin;

use App\Parameters\Parameters;

class ContestParameters extends Parameters
{

    public string $name;
    public string $organization_name;
    public string $max_users;
    public string $name_slug;

    public function __construct(){

        $this->validationRules = [
            'name' => 'required',
            'organization_name' => 'required',
            'name_slug' => '',
            'max_users' => 'required'
        ];

    }

    public function isValid(): bool
    {
        return parent::validate((array)$this);
    }
}
