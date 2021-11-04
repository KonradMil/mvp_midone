<?php

namespace App\Http\Controllers;

use App\Http\ResponseBuilder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected ResponseBuilder $responseBuilder;
    private $obj;
    private $handler;

    public function __construct($target, callable $exceptionHandler = null)
    {
        $this->obj = $target;
        $this->handler = $exceptionHandler;
        $this->responseBuilder = new ResponseBuilder();
    }

    public function __call($method, $arguments)
    {
        try {
            return call_user_func_array([$this->obj, $method], $arguments);
        } catch (\Exception $e) {
            report($e);
            $this->responseBuilder->setErrorMessage(__('messages.error'));
            return $this->responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
