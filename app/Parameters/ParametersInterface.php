<?php

namespace App\Parameters;

use Illuminate\Support\MessageBag;

/**
 *
 */
interface ParametersInterface
{

    /**
     * @return mixed
     */
    public function validate(): bool;

    /**
     * @return MessageBag
     */
    public function getMessageBag(): MessageBag;

    public function getMessagesString(): string;

}
