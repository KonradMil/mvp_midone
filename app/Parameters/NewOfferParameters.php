<?php

namespace App\Parameters;

/**
 *
 */
class NewOfferParameters extends Parameters
{
    /**
     * @var int
     */
    public int $installerId;

    /**
     * @var int
     */
    public int $stage;

    /**
     * @var ?int
     */
    public ?int $offerId;

    /**
     * @var int
     */
    public int $challengeId;

    /**
     * @var ?int
     */
    public ?int $projectId;

    /**
     * @var ?int
     */
    public ?int $solutionId;

    /**
     * @var float
     */
    public float $priceOfDelivery;

    /**
     * @var int
     */
    public int $weeksToStart;

    /**
     * @var int
     */
    public int $timeToStart;

    /**
     * @var int
     */
    public int $timeToFix;

    /**
     * @var int
     */
    public int $advanceUponStart;

    /**
     * @var int
     */
    public int $advanceUponDelivery;

    /**
     * @var int
     */
    public int $advanceUponAgreement;

    /**
     * @var string
     */
    public string $yearsOfGuarantee;

    /**
     * @var ?int
     */
    public ?int $serviceSupportScope;

    /**
     * @var ?string
     */
    public ?string $maintenanceFrequency;

    /**
     * @var float
     */
    public float $priceOfMaintenance;

    /**
     * @var string
     */
    public string $reactionTime;

    /**
     * @var float
     */
    public float $interventionPrice;

    /**
     * @var float
     */
    public float $workHourPrice;

    /**
     * @var ?string
     */
    public ?string $periodOfSupport;

    /**
     * @var int
     */
    public int $offerExpiresIn;

    /**
     * @var ?array
     */
    public ?array $solutionRobots;


    /**
     *
     */
    public function __construct()
    {
        $this->validationRules = [
            'installerId' => 'required|int',
            'challengeId' => 'required|int',
            'offerId' => 'nullable|int',
            'projectId' => 'nullable|int',
            'solutionId' => 'nullable|int',
            'priceOfDelivery' => 'required|numeric',
            'weeksToStart' => 'required|int',
            'timeToStart' => 'required|int',
            'timeToFix' => 'required|int',
            'advanceUponStart' => 'required|int',
            'advanceUponDelivery' => 'required|int',
            'advanceUponAgreement' => 'required|int',
            'yearsOfGuarantee' => 'required|string',
            'serviceSupportScope' => 'nullable|int',
            'maintenanceFrequency' => 'nullable|string',
            'priceOfMaintenance' => 'required|numeric',
            'reactionTime' => 'required|string',
            'interventionPrice' => 'required|numeric',
            'workHourPrice' => 'required|numeric',
            'periodOfSupport' => 'nullable|string',
            'offerExpiresIn' => 'required|int',
            'solutionRobots' => 'nullable|array'
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
