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
    public int $challenge_id;
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
    public int $shift_time;
    /**
     * @var int
     */
    public int $weekend_shift;
    /**
     * @var int
     */
    public int $breakfast;
    /**
     * @var int
     */
    public int $stop_time;
    /**
     * @var int
     */
    public int $operator_performance;
    /**
     * @var int
     */
    public int $defective;
    /**
     * @var int
     */
    public int $number_of_operators;
    /**
     * @var int
     */
    public int $operator_cost;
    /**
     * @var int
     */
    public int $absence;
    /**
     * @var int
     */
    public int $cycle_time;



    /**
     *
     */
    public function __construct()
    {
        $this->validationRules = [
            'challenge_id' => 'required|int',
            'days' => 'required|int',
            'shifts' => 'required|int',
            'shift_time' => 'required|int',
            'weekend_shift' => 'required|int',
            'breakfast' => 'required|int',
            'stop_time' => 'required|int',
            'operator_performance' => 'required|int',
            'defective' => 'required|int',
            'number_of_operators' => 'required|int',
            'operator_cost' => 'required|int',
            'absence' => 'required|int',
            'cycle_time' => 'required|int',
        ];

        $this->validationMessages = [
            'type.in' => __('messages.validation.local_vision.wrong_data')
        ];

        $this->validationSubject = (array)$this;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return parent::validate((array)$this);
    }
}
