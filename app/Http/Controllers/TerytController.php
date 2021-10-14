<?php

namespace App\Http\Controllers;

use GusApi\Exception\NotFoundException;
use GusApi\GusApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


/**
 *
 */
class TerytController extends Controller
{
    /**
     * @var GusApi
     */
    public $client;

    /**
     *
     */
    public function __construct()
    {
        $this->client = new GusApi('d432b081c72a4f3a8863');
        $this->client->login();

    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws NotFoundException
     */
    public function searchRegonNip(Request $request): JsonResponse
    {
        $nip = $request->input('nip');
        if (isset($nip)) {

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

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws NotFoundException
     */
    public function searchRegonKrs(Request $request): JsonResponse
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
