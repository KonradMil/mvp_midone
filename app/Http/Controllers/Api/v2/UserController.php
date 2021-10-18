<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Http\ResponseBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function getCompanyData(): JsonResponse
    {

        $responseBuilder = new ResponseBuilder();

        $user = Auth::user();

        die("TEST");

        return $responseBuilder->getResponse();

    }

}
