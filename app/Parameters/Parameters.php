<?php

namespace App\Parameters;

use Illuminate\Support\MessageBag;

/**
 *
 */
abstract class Parameters implements ParametersInterface
{
    /**
     * @var array
     */
    protected array $validationRules = [];

    /**
     * @var array
     */
    protected array $validationMessages = [];

    /**
     * @var MessageBag
     */
    protected MessageBag $messageBag;

    /**
     * @var array
     */
    protected array $validationSubject;

    /**
     * @return MessageBag
     */
    public function getMessageBag(): MessageBag
    {
        return $this->messageBag;
    }

    public function getMessagesString(): string
    {
        $message = "";

        foreach ($this->messageBag->getMessages() as $msg) {
            foreach($msg as $m) {
                $message .= $m.PHP_EOL;
            }
        }

        return $message;
    }
}
