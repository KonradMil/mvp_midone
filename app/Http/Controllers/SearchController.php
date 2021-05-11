<?php

namespace App\Http\Controllers;

use App\Models\Challenges\Challenge;
use App\Models\Knowledgebase\KnowledgeBaseVideo;
use App\Models\Question;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
//        dd($query);
        $challenges = Challenge::where('status', '=', 1)->where('name', 'LIKE', '%' . $query . '%')->get();
        $questions = Question::where('question',  'LIKE', '%' . $query . '%')->get();
        $knowledge = KnowledgeBaseVideo::where('name',  'LIKE', '%' . $query . '%')->get();

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie',
            'payload' =>  [
                'questions' => $questions,
                'challenges' => $challenges,
                'knowledge' => $knowledge
            ]
        ]);
    }
}
