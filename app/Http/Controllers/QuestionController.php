<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class QuestionController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $input = $request->input();
        $question = new Question();
        $question->question = $input['data']['question'];
        $question->challenge_id = $input['data']['challenge_id'];
        $question->author_id = Auth::user()->id;
        if (!empty($input['data']['isAnswer'])) {
            $question->answer = $input['data']['isAnswer'];
        }
        $question->save();

        return response()->json([
            'success' => true,
            'message' => 'Pytania zostało dodane poprawnie',
            'payload' => $question
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function get(Request $request): JsonResponse
    {
        $questions = Question::where('challenge_id', '=', $request->input('id'))->where('answer', '=', null)->with('answers')->get();

        return response()->json([
            'success' => true,
            'message' => 'Pytania zostały pobrane poprawnie',
            'payload' => $questions
        ]);

    }
}
