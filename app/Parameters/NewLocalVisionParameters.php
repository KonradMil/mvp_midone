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
    public int $authorId;

    /**
     * @var int
     */
    public int $projectId;

    /**
     * @var int
     */
    public int $reportId;

    /**
     * @var string
     */
    public string $description;

    /**
     * @var ?string
     */
    public ?string $before;

    /**
     * @var ?string
     */
    public ?string $after;

    /**
     * @var ?int
     */
    public ?int $accepted;

    /**
     *
     */
    public function __construct()
    {
        $this->validationRules = [
            'authorId' => 'required|int',
            'projectId' => 'required|int',
            'reportId' => 'nullable|int',
            'description' => 'required|string',
            'before' => 'nullable|string',
            'after' => 'nullable|string',
            'accepted' => 'nullable|int'
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
