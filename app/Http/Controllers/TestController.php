<?php

namespace App\Http\Controllers;

use App\Models\MapMarker;
use App\Models\UnityModel;
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
            $check = MapMarker::where('lng', '=', $i['longitude'])->where('lat', '=', $i['latitude'])->where('timestamp', '=', $i['time'])->first();
            if ($check == null) {
                $marker = new MapMarker();
                $marker->lng = $i['longitude'];
                $marker->lat = $i['latitude'];
                $marker->timestamp = $i['time'];
                $marker->save();

                array_push($locations, ['latitude' => $i['latitude'], 'longitude' => $i['longitude'], 'time' => $i['time']]);
            }
        }

        $client = new Client();
        Log::error(json_encode(['json' => [
            'locations' => $locations
        ]]));
        if(!empty($locations)) {
            $response = $client->request('POST', 'https://dev.raily.sptech.pl/api/app/locations', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $inp['locations'][(count($inp)-1)]['token']
                ],
                'json' => [
                    'locations' => $locations
                ]
            ]);

            Log::error('RESPONSE SPTECH');
            Log::error($response->getBody()->getContents());
        }

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
        Log::error('Location came');
        Log::error($inp);
        $locations = [];
        foreach ($inp as $i) {
            Log::error($i);
            $check = MapMarker::where('lng', '=', $i['longitude'])->where('lat', '=', $i['latitude'])->where('timestamp', '=', $i['time'])->first();
            if($check == null) {
                $marker = new MapMarker();
                $marker->lng = $i['longitude'];
                $marker->lat = $i['latitude'];
                $marker->timestamp = $i['time'];
                $marker->save();

                array_push($locations, ['latitude' => $i['latitude'], 'longitude' => $i['longitude'], 'time' => $i['time']]);
            }
        }

        $client = new Client();
        Log::error(json_encode(['json' => [
            'locations' => $locations
        ]]));

        if(!empty($locations)) {
            $response = $client->request('POST', 'https://dev.raily.sptech.pl/api/app/locations', [
                'headers' => [
                    'Accept'     => 'application/json',
                    'Content-Type'     => 'application/json',
                    'Authorization'       => 'Bearer ' . $inp[(count($inp)-1)]['token']
                ],
                'json' => [
                    'locations' => $locations
                ]
            ]);
            Log::error('RESPONSE SPTECH');
            Log::error($response->getBody()->getContents());
        }

        return response()->json('ok');
    }

    public function locationSync (Request $request) {
        $inp = $request->input();
        Log::error('Location came');
        Log::error($inp);
        $locations = [];
        foreach ($inp as $i) {
            $check = MapMarker::where('lng', '=', $i['longitude'])->where('lat', '=', $i['latitude'])->where('timestamp', '=', $i['time'])->first();
            if($check == null) {
                Log::error($i);
                $marker = new MapMarker();
                $marker->lng = $i['longitude'];
                $marker->lat = $i['latitude'];
                $marker->timestamp = $i['time'];
                $marker->save();

                array_push($locations, ['latitude' => $i['latitude'], 'longitude' => $i['longitude'], 'time' => $i['time']]);
            }
        }

        $client = new Client();
        Log::error(json_encode(['json' => [
            'locations' => $locations
        ]]));

        if(!empty($locations)) {
            $response = $client->request('POST', 'https://dev.raily.sptech.pl/api/app/locations', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $inp[(count($inp)-1)]['token']
                ],
                'json' => [
                    'locations' => $locations
                ]
            ]);
            Log::error('RESPONSE SPTECH');
            Log::error($response->getBody()->getContents());
        }

        return response()->json('ok');
    }

    public function importModels()
    {
        $json = '{
    "categories": [
        {
            "name": "Elementy sceny",
            "value": 0,
            "subcategories": [
                {
                    "name": "Maszyny",
                    "value": 0
                },
                {
                    "name": "Transporter",
                    "value": 1
                },
                {
                    "name": "Meble",
                    "value": 2
                },
                {
                    "name": "Stojak",
                    "value": 3
                },
                {
                    "name": "Opakowania - palety",
                    "value": 4
                },
                {
                    "name": "Detale",
                    "value": 5
                }
            ]
        },
        {
            "name": "Roboty",
            "value": 1,
            "subcategories": [
                {
                    "name": "Robot",
                    "value": 0
                },{
                    "name": "Robot kartezjański",
                    "value": 2
                },
                {
                    "name": "Mocowanie",
                    "value": 1
                }

            ]
        },
        {
            "name": "Aplikacja",
            "value": 2,
            "subcategories": [
                {
                    "name": "Chwytak mechaniczny",
                    "value": 0
                },
                {
                    "name": "Chwytak podciśnieniowy",
                    "value": 1
                },
                {
                    "name": "Chwytak elektromagnetyczny",
                    "value": 2
                },
                {
                    "name": "Dysza spawalnicza",
                    "value": 3
                },
                {
                    "name": "Dysza malarska",
                    "value": 4
                },
                {
                    "name": "Kontrola wizyjna",
                    "value": 5
                },
                {
                    "name": "Stacja wymiany chwytaków",
                    "value": 6
                }
            ]
        },
        {
            "name": "Pozycjonowanie detalu",
            "value": 3,
            "subcategories": [
                {
                    "name": "Pozycjoner mechaniczny",
                    "value": 0
                },
                {
                    "name": "Stół podawczy",
                    "value": 1
                },
                {
                    "name": "Regały podawcze",
                    "value": 2
                },
                {
                    "name": "Kamera wizyjna 2D",
                    "value": 3
                },
                {
                    "name": "Kamera wizyjna 3D",
                    "value": 4
                },
                {
                    "name": "Czujniki i sensory",
                    "value": 5
                }
            ]
        },
        {
            "name": "Sterowanie",
            "value": 4,
            "subcategories": [
                {
                    "name": "Sterownik PLC",
                    "value": 0
                },
                {
                    "name": "HMI",
                    "value": 1
                },
                {
                    "name": "Panel sterujący robotem",
                    "value": 2
                },
                {
                    "name": "Oprogramowanie dla robota",
                    "value": 3
                },
                {
                    "name": "Dodatkowe oprogramownie do sterowania",
                    "value": 4
                }
            ]
        },
        {
            "name": "Bezpieczeństwo",
            "value": 5,
            "subcategories": [
                {
                    "name": "Przesła ogrodzenia",
                    "value": 0
                },
                {
                    "name": "Sensory bezpieczeństwa",
                    "value": 1
                },
                {
                    "name": "Furtka",
                    "value": 2
                },
                {
                    "name": "Sygnalizatory",
                    "value": 3
                },
                {
                    "name": "Kurtyna śwetlna",
                    "value": 4
                },
                {
                    "name": "Włączniki bezpieczeństwa",
                    "value": 5
                },
                {
                    "name": "Skanery",
                    "value": 6
                }
            ]
        },
        {
            "name": "Zdalny nadzór",
            "value": 6,
            "subcategories": [
                {
                    "name": "Kamera - podgląd stanowiska",
                    "value": 0
                },
                {
                    "name": "Rejestrator",
                    "value": 1
                },
                {
                    "name": "Połączenie wifi",
                    "value": 2
                },
                {
                    "name": "Połączenie internet",
                    "value": 3
                }
            ]
        },
        {
            "name": "Inne",
            "value": 7,
            "subcategories": [
                {
                    "name": "Inne",
                    "value": 0
                }
            ]
        },
        {
            "name": "Operator",
            "value": 8,
            "subcategories": [
                {
                    "name": "Operator",
                    "value": 0
                }
            ]
        }
    ]
}
';
        $cats = json_decode($json);
//        dd($cats);
        $handle = fopen("../public/modele.csv", "r");
        while (($data = fgetcsv($handle, 0, ';')) !== FALSE) {
           $model = new UnityModel();
           $model->name = $data[5];
           $model->price = 0;
           $model->model_file  = $data[1];
           $model->brand = $data[3];
           $model->model = '';
           $model->max_load_kg = $data[8];
           $model->max_range_mm = $data[9];
           $model->max_speed_mms = $data[10];
           $model->tech_sheet = $data[6];
           $model->axis = $data[7];

           $c = 0;
           $s = 0;
           foreach ($cats->categories as $cat) {
               if($cat->name == $data[0]) {
                   $c = $cat->value;
                   foreach($cat->subcategories as $sub) {
                       if($sub->name == $data[2]) {
                           $s = $sub->value;
                       }
                   }
               }
           }
           $model->category = $c;
           $model->subcategory = $s;
           $model->save();
        }
        dd($cats->categories);
    }
}
