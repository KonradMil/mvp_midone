<?php

namespace App\Parameters;

/**
 *
 */
class NewProjectFilesParameters extends Parameters
{
    /**
     * @var ?array
     */
    public ?array $projectFiles;

    /**
     *
     */
    public function __construct()
    {
        $this->validationRules = [
            'projectFiles' => 'nullable|array',
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
