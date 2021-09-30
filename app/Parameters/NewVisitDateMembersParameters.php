<?php

namespace App\Parameters;

/**
 *
 */
class NewVisitDateMembersParameters extends Parameters
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
            'members' => 'required|string',
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
