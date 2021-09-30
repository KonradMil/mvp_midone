<?php

namespace App\Parameters;

/**
 *
 */
class NewFinancialParameters extends Parameters
{
    /**
     * @var int
     */
    public int $challengeId;
    /**
     * @var int
     */
    public int $days;
    /**
     * @var int
     */
    public int $shifts;
    /**
     * @var int
     */
    public int $shiftTime;
    /**
     * @var int
     */
    public int $weekendShift;
    /**
     * @var int
     */
    public int $breakfast;
    /**
     * @var int
     */
    public int $stopTime;
    /**
     * @var int
     */
    public int $operatorPerformance;
    /**
     * @var int
     */
    public int $defective;
    /**
     * @var int
     */
    public int $numberOfOperators;
    /**
     * @var int
     */
    public int $operatorCost;
    /**
     * @var int
     */
    public int $absence;
    /**
     * @var ?int
     */
    public ?int $cycleTime;



    /**
     *
     */
    public function __construct()
    {
        $this->validationRules = [
            'challengeId' => 'required|int',
            'days' => 'required|int',
            'shifts' => 'required|int',
            'shiftTime' => 'required|int',
            'weekendShift' => 'required|int',
            'breakfast' => 'required|int',
            'stopTime' => 'required|int',
            'operatorPerformance' => 'required|int',
            'defective' => 'required|int',
            'numberOfOperators' => 'required|int',
            'operatorCost' => 'required|int',
            'absence' => 'required|int',
            'cycleTime' => 'nullable',
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
