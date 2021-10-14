<?php

namespace App\Parameters;

/**
 *
 */
class NewFreeSaveParameters extends Parameters
{
    /**
     * @var string
     */
    public string $name;

    /**
     * @var ?string
     */
    public ?string $en_name;

    /**
     * @var ?string
     */
    public ?string $description;

    /**
     * @var ?string
     */
    public ?string $en_description;

    /**
     * @var ?string
     */
    public ?string $save_json;

    /**
     * @var ?string
     */
    public ?string $screenshot_path;

    /**
     *
     */
    public function __construct()
    {
        $this->validationRules = [
            'name' => 'required|string',
            'en_name' => 'nullable|string',
            'description' => 'nullable|string',
            'en_description' => 'nullable|string',
            'screenshot_path' => 'nullable|string',
            'save_json' => 'required|string',
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
