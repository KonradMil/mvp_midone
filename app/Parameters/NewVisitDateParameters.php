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
    public int $author_id;
    /**
     * @var int
     */
    public int $project_id;

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
            'author_id' => 'required|int',
            'project_id' => 'required|int',
            'date' => 'required|date',
            'time' => 'required|string',
        ];

        $this->validationMessages = [
            'type.in' => __('messages.validation.local_vision.wrong_data')
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
