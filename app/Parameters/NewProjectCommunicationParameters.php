<?php

namespace App\Parameters;

/**
 *
 */
class NewProjectCommunicationParameters extends Parameters
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
    public ?int $communicationPlanId;

    /**
     * @var string
     */
    public string $personalOccupation;

    /**
     * @var ?string
     */
    public ?string $personalData;

    /**
     * @var ?string
     */
    public ?string $phoneNumber;

       /**
        * @var ?string
        */
    public ?string $email;

    /**
     * @var ?int
     */
    public ?int $projectDecision;

    /**
     *
     */
    public function __construct()
    {
        $this->validationRules = [
            'authorId' => 'required|int',
            'projectId' => 'required|int',
            'communicationPlanId' => 'nullable|int',
            'personalOccupation' => 'required|string',
            'personalData' => 'required|string',
            'phoneNumber' => 'nullable|string',
            'email' => 'nullable|string',
            'projectDecision' => 'nullable|int'
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
