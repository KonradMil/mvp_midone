<?php

namespace App\Parameters;

/**
 *
 */
class NewSolutionFilesParameters extends Parameters
{
    /**
     * @var ?array
     */
    public ?array $solutionFiles;

    /**
     *
     */
    public function __construct()
    {
        $this->validationRules = [
            'solutionFiles' => 'nullable|array',
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
