<?php

namespace App\Parameters\Admin;

use App\Parameters\Parameters;

class ShowroomSlideParameters extends Parameters
{

    public string $name;

    public string $menu_name;

    public string $content;

    public int $type;

    public function __construct(){

        $this->validationRules = [
            'name' => 'required',
            'menu_name' => 'required',
            'content' => 'required',
            'type' => 'required',
        ];

    }

    public function isValid(): bool
    {
        return parent::validate((array)$this);
    }
}
