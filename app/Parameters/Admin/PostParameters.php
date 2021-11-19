<?php

namespace App\Parameters\Admin;

use App\Parameters\Parameters;
use phpDocumentor\Reflection\Types\Integer;

class PostParameters extends Parameters
{

    public string $body;
    public string $markdown;
    public Integer $discussion_id;

    public function __construct(){

        $this->validationRules = [
            'body' => 'required',
            'markdown' => '',
            'discussion_id' => 'required',
        ];

    }

    public function isValid(): bool
    {
        return parent::validate((array)$this);
    }
}
