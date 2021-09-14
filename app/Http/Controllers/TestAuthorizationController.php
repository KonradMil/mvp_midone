<?php

namespace App\Http\Controllers;

class TestAuthorizationController extends Controller
{

    public function searchAction()
    {
        return response()->json(["SEARCH ACTION"]);
    }

    public function getAction()
    {
        return response()->json(["GET ACTION"]);
    }

    public function updateAction()
    {
        return response()->json(["UPDATE ACTION"]);
    }

    public function deleteAction()
    {
        return response()->json(["DELETE ACTION"]);
    }

}
