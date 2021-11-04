<?php

namespace App\Http\Controllers;

use App\Http\ResponseBuilder;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected ResponseBuilder $responseBuilder;

    public function __construct()
    {
        $this->responseBuilder = new ResponseBuilder();
    }

    public function __call($method, $arguments)
    {
        try {
            return call_user_func_array($method, $arguments);
        } catch (\Exception $e) {
            report($e);
            $this->responseBuilder->setErrorMessage(__('messages.error'));
            return $this->responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
