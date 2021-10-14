<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class CompanyController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveCompany(Request $request): JsonResponse
    {
        $input = $request->input();
        if (isset(Auth::user()->companies[0])) {
            $company = Auth::user()->companies[0];
        } else {
            $company = new Company();
        }

        $company->fill($input);
        $company->author_id = Auth::user()->id;
        $company->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $company
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function getUserCompanies(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie',
            'payload' => Auth::user()->companies
        ]);
    }
}
