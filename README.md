# DBR77 System - installation guide

## Requirements
System requirements description is not ready yet.

## Run with Docker

In the project root directory run following commands:

    $ cp .env.example .env
    $ sudo docker-compose up -d
    $ sudo docker exec -it php_dbr77 bash
    # composer install
    # php artisan key:generate
    # php artisan migrate
    # php artisan db:seed
    # exit

Go to http://localhost

### STAGES:
0 - draft

1 - awaiting solution

2 - awaiting offer

3 - agreement planning

4 - project planning

5 - project accepting

6 - invoicing

### STATUS
0 - draft

1 - published

### TYPES
0 - pick and place

### MODEL CATEGORIES
```
private $category = [
[
"name" => "Elementy sceny",
"value" => 0
],
[
"name" => "Roboty",
"value" => 1
],
[
"name" => "Aplikacja",
"value" => 2
],
[
"name" => "Pozycjonowanie detalu",
"value" => 3
],
[
"name" => "Sterowanie",
"value" => 4
],
[
"name" => "Bezpieczeństwo",
"value" => 5
],
[
"name" => "Zdalny nadzór",
"value" => 6
],
[
"name" => "Inne",
"value" => 7
],
[
"name" => "Operator",
"value" => 8
]
];
```
```
    private $subcategory = [
        [ //0
            [
                "name" => "Maszyny",
                "value" => 0
            ],
            [
                "name" => "Transporter",
                "value" => 1
            ],
            [
                "name" => "Meble",
                "value" => 2
            ],
            [
                "name" => "Stojak",
                "value" => 3
            ],
            [
                "name" => "Opakowania - palety",
                "value" => 4
            ],
            [
                "name" => "Detale",
                "value" => 5
            ]
        ],
        [ //1
            [
                "name" => "Robot",
                "value" => 0
            ],
            [
                "name" => "Mocowanie",
                "value" => 1
            ]
        ],
        [ // 2
            [
                "name" => "Chwytak mechaniczny",
                "value" => 0
            ],
            [
                "name" => "Chwytak podciśnieniowy",
                "value" => 1
            ],
            [
                "name" => "Chwytak elektromagnetyczny",
                "value" => 2
            ],
            [
                "name" => "Dysza spawalnicza",
                "value" => 3
            ],
            [
                "name" => "Dysza malarska",
                "value" => 4
            ],
            [
                "name" => "Kontrola wizyjna",
                "value" => 5
            ],
            [
                "name" => "Stacja wymiany chwytaków",
                "value" => 6
            ]
        ],
        [ // 3
            [
                "name" => "Pozycjoner mechaniczny",
                "value" => 0
            ],
            [
                "name" => "Stół podawczy",
                "value" => 1
            ],
            [
                "name" => "Regały podawcze",
                "value" => 2
            ],
            [
                "name" => "Kamera wizyjna 2D",
                "value" => 3
            ],
            [
                "name" => "Kamera wizyjna 3D",
                "value" => 4
            ],
            [
                "name" => "Czujniki i sensory",
                "value" => 5
            ]
        ],
        [ // 4
            [
                "name" => "Sterownik PLC",
                "value" => 0
            ],
            [
                "name" => "HMI",
                "value" => 1
            ],
            [
                "name" => "Panel sterujący robotem",
                "value" => 2
            ],
            [
                "name" => "Oprogramowanie dla robota",
                "value" => 3
            ],
            [
                "name" => "Dodatkowe oprogramownie do sterowania",
                "value" => 4
            ]
        ],
        [ // 5
            [
                "name" => "Przesła ogrodzenia",
                "value" => 0
            ],
            [
                "name" => "Sensory bezpieczeństwa",
                "value" => 1
            ],
            [
                "name" => "Furtka",
                "value" => 2
            ],
            [
                "name" => "Sygnalizatory",
                "value" => 3
            ],
            [
                "name" => "Kurtyna śwetlna",
                "value" => 4
            ],
            [
                "name" => "Włączniki bezpieczeństwa",
                "value" => 5
            ],
            [
                "name" => "Skanery",
                "value" => 6
            ]
        ],
        [ // 6
            [
                "name" => "Kamera - podgląd stanowiska",
                "value" => 0
            ],
            [
                "name" => "Rejestrator",
                "value" => 1
            ],
            [
                "name" => "Połączenie wifi",
                "value" => 2
            ],
            [
                "name" => "Połączenie internet",
                "value" => 3
            ]
        ],
        [ // 7
            [
                "name" => "Inne",
                "value" => 0
            ],
        ],
        [ // 8
            [
                "name" => "Operator",
                "value" => 0
            ],
        ]
    ];
```
