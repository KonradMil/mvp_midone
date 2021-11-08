<?php

namespace App\Parameters\Admin;

use App\Parameters\Parameters;

class ShowroomParameters extends Parameters
{

    public string $challenge_id;
    public string $name;
    public string $custom_css;
    public string $custom_functions;
    public string $description;
    public string $organization;
    public string $organization_logo;
    public string $dominant_color;


    public function __construct(){

        $this->validationRules = [
            'name' => 'required',
            'challenge_id' => 'required',
            'custom_functions' => '',
            'organization_logo' => '',
            'organization' => 'required',
            'description' => 'required',
            'custom_css' => ''
        ];

    }

    public function isValid(): bool
    {
        return parent::validate((array)$this);
    }
}
