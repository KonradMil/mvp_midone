<?php

namespace App\Http\Requests\Handlers;

use Illuminate\Http\Request;

/**
 *
 */
abstract class RequestHandler implements RequestHandlerInterface
{
    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
