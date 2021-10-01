<?php

namespace App\Parameters;

use Illuminate\Support\MessageBag;

/**
 *
 */
interface ParametersInterface
{

    /**
     * @return MessageBag
     */
    public function getMessageBag(): MessageBag;

    /**
     * @return string
     */
    public function getMessagesString(): string;

    /**
     * @param array $subject
     * @return bool
     */
    public function validate(array $subject): bool;

    /**
     * @return bool
     */
    public function isValid(): bool;

}
