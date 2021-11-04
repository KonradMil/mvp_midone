<?php

namespace App\Parameters\Admin;

use App\Parameters\Parameters;

class ShowroomParameters extends Parameters
{

    public string $challenge_id;

    public string $name;

    public string $custom_css;


    public function __construct(){

        $this->validationRules = [
            'name' => 'required',
            'challenge_id' => 'required',
            'custom_css' => ''
        ];

    }

    public function isValid(): bool
    {
        return parent::validate((array)$this);
    }
}
