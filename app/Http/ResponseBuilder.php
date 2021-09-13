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
     * @var string|null
     */
    private ?string $message = null;

    /**
     * @var array
     */
    private array $errors = [];

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

        if ($this->message) {
            $responseData['message'] = $this->message;
        }

        if ($this->hasErrors()) {
            $responseData['errors'] = $this->errors;
        }

        if (!empty($this->data)) {
            $responseData['data'] = $this->data;
        }

        return new JsonResponse($responseData, $code);
    }

    /**
     * @param array $messages
     */
    public function setErrors(array $messages)
    {
        foreach ($messages as $msg) {
            $this->setError($msg['message'], $msg['context']);
        }
    }

    /**
     * @param string $message
     * @param string $context
     */
    public function setError(string $message, string $context = 'general')
    {

        $contextKey = null;

        foreach ($this->errors as $k => $e) {

            if ($e['context'] === $context) {
                $contextKey = $k;
            }
        }

        if ($contextKey !== null) {
            $this->errors[$contextKey]['messages'][] = $message;
        } else {
            $this->errors[] = [
                'context' => $context,
                'messages' => [$message]
            ];
        }

    }

    /**
     * @param MessageBag $messageBag
     */
    public function setErrorsFromMB(MessageBag $messageBag)
    {
        foreach ($messageBag->getMessages() as $k => $msg) {
            foreach ($msg as $m) {
                $this->setError($m, $k);
            }
        }
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * @param string|null $message
     */
    public function setMessage(?string $message)
    {
        $this->message = $message;
    }

    /**
     * @param string $key
     * @param $value
     */
    public function addData(string $key, $value)
    {
        $this->data[$key] = $value;
    }

}
