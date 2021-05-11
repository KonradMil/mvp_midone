<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function create(Request $request)
    {
        $input = $request->input();
        $question = new Question();
        $question->question = $input['data']['question'];
        $question->challenge_id = $input['data']['challenge_id'];
        $question->author_id = Auth::user()->id;
        $question->save();

        return response()->json([
            'success' => true,
            'message' => 'Pytania zostało dodane poprawnie',
            'payload' => $question
        ]);
    }

    public function get(Request $request) {
          $questions = Question::where('challenge_id', '=', $request->input('id'))->get();

        return response()->json([
            'success' => true,
            'message' => 'Pytania zostały pobrane poprawnie',
            'payload' => $questions
        ]);

    }
}
