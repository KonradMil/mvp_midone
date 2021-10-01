<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\KnowledgeBaseVideo;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 *
 */
class SearchController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
//        dd($query);
        $challenges = Challenge::where('status', '=', 1)->where('name', 'LIKE', '%' . $query . '%')->get();
        $questions = Question::where('question', 'LIKE', '%' . $query . '%')->get();
        $knowledge = KnowledgeBaseVideo::where('name', 'LIKE', '%' . $query . '%')->get();

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie',
            'payload' => [
                'questions' => $questions,
                'challenges' => $challenges,
                'knowledge' => $knowledge
            ]
        ]);
    }
}
