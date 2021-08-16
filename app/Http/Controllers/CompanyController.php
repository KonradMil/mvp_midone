<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function saveCompany(Request $request)
    {
        $input = $request->input();
        if(isset(Auth::user()->companies[0])) {
            $company = Auth::user()->companies[0];
        } else {
            $company = new Company();
        }

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
        $company = Company::find($input['id']);
        $company->fill($input);
        $company->flat_nr = $input['flat_nr'];
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
