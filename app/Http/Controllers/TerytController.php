<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mrcnpdlk\Api\Regon\Api;
use Mrcnpdlk\Api\Regon\Config;

class TerytController extends Controller
{
    public function searchRegonNip(Request $request)
    {
        $nip = $request->input('nip');
        $oConfig = new Config([
            'password' => 'd432b081c72a4f3a8863',
        ]);

        $oApi = new Api($oConfig);
        $resp = $oApi->searchByNip($nip);
        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $resp
        ]);
    }

    public function searchRegonKrs()
    {
        $ss = Request::input('krs');
        $oConfig = new Config([
            'password' => 'd432b081c72a4f3a8863',
        ]);

        $oApi = new Api($oConfig);
        $resp = $oApi->searchByKrs($ss);
        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $resp
        ]);
    }
}
