<?php

namespace App\Http\Controllers\API;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function saveCompany(Request $request)
    {
        $input = $request->input();
        $company = new Company();
        $company->fill($input);
        $company->author_id = Auth::user()->id;
        $company->save();
        $company->users()->attach(Auth::user());

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $company
        ]);
    }
    public function saveCompanyEdit(Request $request)
    {
        $input = $request->input();
        $company = Company::find($input->id);
        $company->fill($input);
//        $company->author_id = Auth::user()->id;
        $company->save();
//        $company->users()->attach(Auth::user());

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $company
        ]);
    }
    public function getUserCompanies()
    {
        return response()->json([
           'success' => true,
           'message' => 'Pobrano poprawnie',
           'payload' => Auth::user()->companies
        ]);
    }
}
