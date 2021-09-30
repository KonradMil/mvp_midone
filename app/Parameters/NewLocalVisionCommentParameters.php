<?php

namespace App\Parameters;

/**
 *
 */
class NewLocalVisionCommentParameters extends Parameters
{
    /**
     * @var string
     */
    public string $members;

    /**
     *
     */
    public function __construct()
    {
        $this->validationRules = [
            'comment' => 'required|string',
        ];

        $this->validationSubject = (array)$this;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return parent::validate((array)$this);
    }
}
