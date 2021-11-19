<?php

namespace App\Parameters\Admin;

use App\Parameters\Parameters;
use phpDocumentor\Reflection\Types\Integer;

class CategoryParameters extends Parameters
{

    public string $name;
    public string $order;
    public string $subtitle;
    public string $slug;
    public string $color;
    public int $parent_id;


    public function __construct(){

        $this->validationRules = [
            'name' => 'required',
            'order' => 'required',
            'subtitle' => '',
            'slug' => 'required',
            'color' => '',
            'parent_id' => ''
        ];

    }

    public function isValid(): bool
    {
        return parent::validate((array)$this);
    }
}
