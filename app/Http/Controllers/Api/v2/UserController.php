<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Http\ResponseBuilder;
use App\Models\Company;
use App\Repository\Eloquent\CompanyRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function getCompanyData(CompanyRepository $companyRepository): JsonResponse
    {

        $responseBuilder = new ResponseBuilder();

        $user = Auth::user();

        /** @var Company $company */
        $company = $companyRepository->findByAuthorId($user->id);
        $responseBuilder->setData('isValid', $company->isDataFilled());

        return $responseBuilder->getResponse();

    }

}
