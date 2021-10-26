<?php

namespace App\Parameters;

/**
 *
 */
class NewProjectConceptParameters extends Parameters
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
     * @var ?int
     */
    public ?int $conceptId;

    /**
     * @var string
     */
    public string $title;

    /**
     * @var ?string
     */
    public ?string $description;

    /**
     * @var ?array
     */
    public ?array $files;


    /**
     *
     */
    public function __construct()
    {
        $this->validationRules = [
            'authorId' => 'required|int',
            'projectId' => 'required|int',
            'conceptId' => 'nullable|int',
            'title' => 'required|string',
            'description' => 'required|string',
            'files' => 'nullable|array'
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
