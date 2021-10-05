<?php

namespace App\Parameters;

/**
 *
 */
class NewSolutionFilesParameters extends Parameters
{
    /**
     * @var ?string
     */
    public ?string $name;

    /**
     * @var string
     */
    public string $ext;

    /**
     * @var ?string
     */
    public ?string $originalName;

    /**
     * @var ?string
     */
    public ?string $path;

    /**
     * @var string
     */
    public string $thumbnail;

    /**
     * @var ?string
     */
    public ?string $size;

    /**
     * @var ?string
     */
    public ?string $alt;

    /**
     *
     */
    public function __construct()
    {
        $this->validationRules = [
            'name' => 'nullable|string',
            'ext' => 'string',
            'original_name' => 'string',
            'path' => 'string',
            'thumbnail' => 'nullable|string',
            'size' => 'nullable|string',
            'alt' => 'nullable|string',
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
