<?php

namespace App\Parameters;

/**
 *
 */
class NewLocalVisionParameters extends Parameters
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
    public string $description;

    /**
     * @var string
     */
    public string $before;

    /**
     * @var string
     */
    public string $after;

    /**
     * @var int
     */
    public int $accepted;

    /**
     *
     */
    public function __construct()
    {
        $this->validationRules = [
            'author_id' => 'required|int',
            'project_id' => 'required|int',
            'description' => 'required|string',
            'before' => 'required|string',
            'after' => 'required|string',
            'accepted' => 'nullable|int'
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
