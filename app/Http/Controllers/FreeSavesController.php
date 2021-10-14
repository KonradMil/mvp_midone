<?php

namespace App\Http\Controllers;

use App\Http\Requests\Handlers\LocalVisionHandler;
use App\Http\ResponseBuilder;
use App\Repository\Eloquent\FreeSavesRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FreeSavesController extends Controller
{
    public function __construct()
    {

    }

    public function get(Request $request, FreeSavesRepository $freeSavesRepository)
    {

    }

    public function getSave(Request $request, FreeSavesRepository $freeSavesRepository)
    {

    }

    public function saveData(Request $request, FreeSavesRepository $freeSavesRepository)
    {

    }
}
