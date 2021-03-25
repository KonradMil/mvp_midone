<?php

namespace App\Http\Controllers;

use App\Models\MapMarker;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function locations(Request $request)
    {
        $inp = $request->input();
        Log::error('Location came');
        Log::error($inp);
        $locations = [];
        foreach ($inp['locations'] as $i) {
            Log::error($i);
            $marker = new MapMarker();
            $marker->lng = $i['longitude'];
            $marker->lat = $i['latitude'];
            $marker->timestamp = $i['time'];
            $marker->save();

            array_push($locations, ['latitude' => $i['latitude'], 'longitude' => $i['longitude'], 'time' => $i['time']]);
        }

        $client = new Client();
        Log::error(json_encode(['json' => [
            'locations' => $locations
        ]]));
        $response = $client->request('POST', 'https://dev.raily.sptech.pl/api/app/locations', [
            'headers' => [
                'Accept'     => 'application/json',
                'Content-Type'     => 'application/json',
                'Authorization'       => 'Bearer ' . $inp['locations'][0]['token']
            ],
            'json' => [
                'locations' => $locations
            ]
        ]);
        Log::error('RESPONSE SPTECH');
        Log::error($response->getBody()->getContents());


        return response()->json('ok');

    }

    public function getLocations()
    {
        $markers = MapMarker::orderBy('created_at', 'DESC')->take(250)->get();
        return response()->json($markers);
    }

    public function locationsOwn(Request $request)
    {
        $inp = $request->input();
        Log::error('Location OWN came');
        Log::error($inp);
    }
}
