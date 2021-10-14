<?php

namespace App\Parameters;

/**
 *
 */
class NewFreeSave extends Parameters
{
    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $en_name;

    /**
     * @var string
     */
    public string $description;

    /**
     * @var string
     */
    public string $en_description;

    /**
     * @var object
     */
    public object $save_json;

    /**
     * @var string
     */
    public string $screenshot_path;


    /**
     *
     */
    public function __construct()
    {
        $this->validationRules = [
            'name' => 'required|string',
            'en_name' => 'string',
            'description' => 'required|string',
            'en_description' => 'string',
            'screenshot_path' => 'required|string',
            'save_json' => 'required',
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
