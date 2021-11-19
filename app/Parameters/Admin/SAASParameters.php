<?php

namespace App\Parameters\Admin;

use App\Parameters\Parameters;

class SAASParameters extends Parameters
{

    public string $name;
    public string $organization_name;
    public string $organization_logo;
    public string $email_regexp;
    public string $max_users;
    public string $organization_slug;
    public string $paid;

    public function __construct(){

        $this->validationRules = [
            'name' => 'required',
            'organization_name' => 'required',
            'organization_logo' => '',
            'organization_slug' => '',
            'email_regexp' => '',
            'max_users' => 'required',
            'paid' => ''
        ];

    }

    public function isValid(): bool
    {
        return parent::validate((array)$this);
    }
}
