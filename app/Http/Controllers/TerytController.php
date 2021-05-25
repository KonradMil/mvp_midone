<?php

namespace App\Http\Controllers;

use GusApi\GusApi;
use Illuminate\Http\Request;


class TerytController extends Controller
{
    public $client;

    public function __construct()
    {
        $this->client = new GusApi('d432b081c72a4f3a8863');
        $this->client->login();

    }

    public function searchRegonNip(Request $request)
    {
        $nip = $request->input('nip');
        if(isset($nip)) {

            $resp = $this->client->getByNip($nip);

            return response()->json([
                'success' => true,
                'message' => 'Zapisano poprawnie',
                'payload' => $resp[0]
            ]);
        } else {
            $regon = $request->input('regon');
            $resp = $this->client->getByRegon($regon);
            return response()->json([
                'success' => true,
                'message' => 'Zapisano poprawnie',
                'payload' => $resp[0]
            ]);
        }

    }

    public function searchRegonKrs(Request $request)
    {
        $ss = $request->input('krs');
        $resp = $this->client->getByKrs($ss);
        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $resp[0]
        ]);
    }
}
