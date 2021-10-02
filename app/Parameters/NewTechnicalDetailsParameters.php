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
    public int $challengeId;
    /**
     * @var int
     */
    public int $detailWeight;
    /**
     * @var int
     */
    public int $pickQuality;
    /**
     * @var int
     */
    public int $detailMaterial;
    /**
     * @var int
     */
    public int $detailSize;
    /**
     * @var int
     */
    public int $detailPick;
    /**
     * @var int
     */
    public int $detailPosition;
    /**
     * @var int
     */
    public int $detailRange;
    /**
     * @var int
     */
    public int $detailDestination;
    /**
     * @var int
     */
    public int $numberOfLines;
    /**
     * @var int
     */
    public int $workShifts;

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
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return parent::validate((array)$this);
    }
}
