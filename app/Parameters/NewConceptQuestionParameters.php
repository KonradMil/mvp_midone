<?php

namespace App\Parameters;

/**
 *
 */
class NewConceptQuestionParameters extends Parameters
{
    /**
     * @var int
     */
    public int $authorId;

    /**
     * @var ?int
     */
    public ?int $conceptId;

    /**
     * @var ?string
     */
    public ?string $question;

    /**
     *
     */
    public function __construct()
    {
        $this->validationRules = [
            'authorId' => 'int',
            'conceptId' => 'int',
            'question' => 'required|string',
        ];
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return parent::validate((array)$this);
    }
}
