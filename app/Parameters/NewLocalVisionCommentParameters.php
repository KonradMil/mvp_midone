<?php

namespace App\Parameters;

/**
 *
 */
class NewLocalVisionCommentParameters extends Parameters
{
    /**
     * @var string
     */
    public string $comment;

    /**
     *
     */
    public function __construct()
    {
        $this->validationRules = [
            'comment' => 'nullable|string',
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
