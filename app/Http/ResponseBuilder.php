<?php


namespace App\Http;


use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class ResponseBuilder
{

    /**
     * @var array
     */
    private array $errorMessages = [];

    /**
     * @var array
     */
    private array $warningMessages = [];

    /**
     * @var array
     */
    private array $successMessages = [];

    /**
     * @var array
     */
    private array $infoMessages = [];

    /**
     * @var array
     */
    private array $data = [];

    /**
     * @param int $code
     * @return JsonResponse
     */
    public function getResponse(int $code = Response::HTTP_OK): JsonResponse
    {
        $responseData = [];

        if (!empty($this->errorMessages)) {
            $responseData['errors'] = $this->errorMessages;
        }

        if (!empty($this->warningMessages)) {
            $responseData['warnings'] = $this->warningMessages;
        }

        if (!empty($this->successMessages)) {
            $responseData['success'] = $this->successMessages;
        }

        if (!empty($this->infoMessages)) {
            $responseData['info'] = $this->infoMessages;
        }

        if (!empty($this->data)) {
            $responseData = array_merge($responseData, $this->data);
        }

        return new JsonResponse($responseData, $code);
    }

    /**
     * @param string $message
     */
    public function setErrorMessage(string $message)
    {

        $this->errorMessages[] = $message;

    }

    /**
     * @param array $messages
     */
    public function setErrorMessages(array $messages)
    {
        foreach ($messages as $msg) {
            $this->setErrorMessage($msg['message']);
        }
    }

    /**
     * @param MessageBag $messageBag
     */
    public function setErrorMessagesFromMB(MessageBag $messageBag)
    {
        foreach ($messageBag->getMessages() as $msg) {
            foreach ($msg as $m) {
                $this->setErrorMessage($m);
            }
        }
    }

    /**
     * @param string $message
     */
    public function setWarningMessage(string $message)
    {

        $this->warningMessages[] = $message;

    }

    /**
     * @param array $messages
     */
    public function setWarningMessages(array $messages)
    {
        foreach ($messages as $msg) {
            $this->setWarningMessage($msg['message']);
        }
    }

    /**
     * @param MessageBag $messageBag
     */
    public function setWarningsFromMB(MessageBag $messageBag)
    {
        foreach ($messageBag->getMessages() as $k => $msg) {
            foreach ($msg as $m) {
                $this->setWarningMessage($m);
            }
        }
    }

    /**
     * @param string $message
     */
    public function setSuccessMessage(string $message)
    {

        $this->successMessages[] = $message;

    }

    /**
     * @param array $messages
     */
    public function setSuccessMessages(array $messages)
    {
        foreach ($messages as $msg) {
            $this->setSuccessMessage($msg['message']);
        }
    }

    /**
     * @param MessageBag $messageBag
     */
    public function setSuccessMessagesFromMB(MessageBag $messageBag)
    {
        foreach ($messageBag->getMessages() as $k => $msg) {
            foreach ($msg as $m) {
                $this->setSuccessMessage($m);
            }
        }
    }

    /**
     * @param string $message
     */
    public function setInfoMessage(string $message)
    {

        $this->infoMessages[] = $message;

    }

    /**
     * @param array $messages
     */
    public function setInfoMessages(array $messages)
    {
        foreach ($messages as $msg) {
            $this->setInfoMessage($msg['message']);
        }
    }

    /**
     * @param MessageBag $messageBag
     */
    public function setInfoMessagesFromMB(MessageBag $messageBag)
    {
        foreach ($messageBag->getMessages() as $k => $msg) {
            foreach ($msg as $m) {
                $this->setInfoMessage($m);
            }
        }
    }

    /**
     * @param string $key
     * @param $value
     */
    public function setData(string $key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * @return array
     */
    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }

    /**
     * @return array
     */
    public function getWarningMessages(): array
    {
        return $this->warningMessages;
    }

    /**
     * @return array
     */
    public function getSuccessMessages(): array
    {
        return $this->successMessages;
    }

    /**
     * @return array
     */
    public function getInfoMessages(): array
    {
        return $this->infoMessages;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

}
