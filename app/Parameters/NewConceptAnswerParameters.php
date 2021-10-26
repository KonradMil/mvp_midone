<?php

namespace App\Parameters;

/**
 *
 */
class NewConceptAnswerParameters extends Parameters
{
    /**
     * @var int
     */
    public int $authorId;

    /**
     * @var ?int
     */
    public ?int $conceptQuestionId;

    /**
     * @var ?string
     */
    public ?string $answer;

    /**
     *
     */
    public function __construct()
    {
        $this->validationRules = [
            'authorId' => 'int',
            'conceptQuestionId' => 'int',
            'answer' => 'required|string',
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
