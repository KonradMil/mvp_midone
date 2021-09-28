<?php

namespace App\Parameters;

/**
 *
 */
class NewTechnicalDetailsParameters extends Parameters
{
    /**
     * @var int
     */
    public int $challenge_id;
    /**
     * @var int
     */
    public int $detail_weight;
    /**
     * @var int
     */
    public int $pick_quality;
    /**
     * @var int
     */
    public int $detail_material;
    /**
     * @var int
     */
    public int $detail_size;
    /**
     * @var int
     */
    public int $detail_pick;
    /**
     * @var int
     */
    public int $detail_position;
    /**
     * @var int
     */
    public int $detail_range;
    /**
     * @var int
     */
    public int $detail_destination;
    /**
     * @var int
     */
    public int $number_of_lines;
    /**
     * @var int
     */
    public int $work_shifts;

    /**
     *
     */
    public function __construct()
    {
        $this->validationRules = [
            'challenge_id' => 'required|int',
            'detail_weight' => 'required|int',
            'pick_quality' => 'required|int',
            'detail_material' => 'required|int',
            'detail_size' => 'required|int',
            'detail_pick' => 'required|int',
            'detail_position' => 'required|int',
            'detail_range' => 'required|int',
            'detail_destination' => 'required|int',
            'number_of_lines' => 'required|int',
            'work_shifts' => 'required|int',
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
