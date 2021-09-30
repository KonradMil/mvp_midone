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
            'challengeId' => 'required|int',
            'detailWeight' => 'required|int',
            'pickQuality' => 'required|int',
            'detailMaterial' => 'required|int',
            'detailSize' => 'required|int',
            'detailPick' => 'required|int',
            'detailPosition' => 'required|int',
            'detailRange' => 'required|int',
            'detailDestination' => 'required|int',
            'numberOfLines' => 'required|int',
            'workShifts' => 'required|int',
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
