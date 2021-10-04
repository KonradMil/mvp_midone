<?php

namespace App\Parameters;

use Illuminate\Support\Facades\Validator;
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

    /**
     * @return string
     */
    public function getMessagesString(): string
    {
        $message = "";

        foreach ($this->messageBag->getMessages() as $msg) {
            foreach ($msg as $m) {
                $message .= $m . PHP_EOL;
            }
        }

        return $message;
    }

    /**
     * @param array $subject
     * @return bool
     */
    public function validate(array $subject): bool
    {
        $validator = Validator::make($subject, $this->validationRules, $this->validationMessages);
        $fails = $validator->fails();

        if ($fails) {
            $this->messageBag = $validator->getMessageBag();
        }

        return !$fails;
    }
}
