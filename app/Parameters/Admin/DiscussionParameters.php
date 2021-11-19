<?php

namespace App\Parameters\Admin;

use App\Parameters\Parameters;

class DiscussionParameters extends Parameters
{

    public string $title;
    public int $category_id;
    public string $color;
    public string $slug;
    public string $body;
    public int $sticky;
    public int $user_id;

    public function __construct(){

        $this->validationRules = [
            'title' => 'required',
            'category_id' => 'required',
        ];

    }

    public function isValid(): bool
    {
        return parent::validate((array)$this);
    }
}
