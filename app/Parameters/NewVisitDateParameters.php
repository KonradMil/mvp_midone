<?php

namespace App\Parameters;

/**
 *
 */
class NewVisitDateParameters extends Parameters
{
    /**
     * @var int
     */
    public int $authorId;
    /**
     * @var int
     */
    public int $projectId;

    /**
     * @var string
     */
    public string $date;

    /**
     * @var string
     */
    public string $time;

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
            'authorId' => 'required|int',
            'projectId' => 'required|int',
            'date' => 'required|date',
            'time' => 'required|string',
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
