<?php

namespace App\Parameters;

/**
 *
 */
class NewProjectRiskParameters extends Parameters
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
    public ?int $riskId;

    /**
     * @var string
     */
    public string $riskDescription;

    /**
     * @var ?string
     */
    public ?string $riskArea;

    /**
     * @var ?int
     */
    public ?int $eventProbability;

       /**
        * @var ?int
        */
    public ?int $costImpact;

    /**
     * @var ?int
     */
    public ?int $scheduleImpact;

    /**
     * @var ?int
     */
    public ?int $qualityImplementationImpact;

    /**
     * @var ?string
     */
    public ?string $riskLimitations;

    /**
     * @var ?string
     */
    public ?string $commentIntegrator;

    /**
     * @var ?string
     */
    public ?string $commentInvestor;

    /**
     *
     */
    public function __construct()
    {
        $this->validationRules = [
            'authorId' => 'required|int',
            'projectId' => 'required|int',
            'riskId' => 'nullable|int',
            'riskDescription' => 'required|string',
            'riskArea' => 'required|string',
            'eventProbability' => 'nullable|int',
            'costImpact' => 'nullable|int',
            'scheduleImpact' => 'nullable|int',
            'qualityImplementationImpact' => 'nullable|int',
            'riskLimitations' => 'nullable|string',
            'commentIntegrator' => 'nullable|string',
            'commentInvestor' => 'nullable|string'
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
