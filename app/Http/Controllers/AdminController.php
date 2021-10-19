<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Project;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminGetProjects(Request $request)
    {
        $size = $request->get('size');
        $page = $request->get('page');
        $filter = $request->get('filters');

        $query = Challenge::query();
        if(isset($filter)) {
            $filter = $filter[0];
            if(isset($filter['value'])){
                $query->where($filter['field'], $filter['type'], $filter['value']);
            }
        }
        $query->take($size)->offset(($page - 1) * $size);
        $query->with(['author', 'solutionSelected', 'solutionSelected.author']);
//        dd($query->get());
//        ,'author.name', 'author.lastname', 'author.email', 'solutionSelected.name', 'solutionSelected.screenshot_path', 'solutionSelected.author.name', 'solutionSelected.author.last_name', 'solutionSelected.author.email'
//        select(['challenges.name', 'challenges.offer_deadline', 'challenges.solution_deadline', 'challenges.screenshot_path', 'challenges.stage', 'challenges.status', 'challenges.type', 'challenges.created_at'])
        return response()->json(['last_page' => ceil($query->count() / $size), 'data' => $query->get()]);
    }
}
