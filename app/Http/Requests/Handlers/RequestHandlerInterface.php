<?php

namespace App\Http\Requests\Handlers;

use App\Parameters\ParametersInterface;
use Illuminate\Http\Request;

/**
 *
 */
interface RequestHandlerInterface
{

    /**
     * @param Request $request
     */
    public function __construct(Request $request);

    /**
     * @return ParametersInterface
     */
    public function getParameters(): ParametersInterface;

    /**
     * @return mixed
     */
    public function authorize(): bool;

}
