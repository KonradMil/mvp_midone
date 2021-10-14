<?php

namespace App\Http\Controllers;

use App\Events\CommentAdded;
use App\Models\Challenge;
use App\Models\KnowledgeBaseVideo;
use App\Models\Solution;
use BeyondCode\Comments\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class CommentsController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function commentDelete(Request $request): JsonResponse
    {
        $id = $request->input('id');
        Comment::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Usunięto poprawnie',
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function comment(Request $request): JsonResponse
    {
        $user = Auth::user();
        $id = $request->input('id');
        $message = $request->input('message');
        if ($request->type === 'challenge') {
            $object = Challenge::find($id);
        } elseif ($request->type === 'knowledge') {
            $object = KnowledgeBaseVideo::find($id);
        } elseif ($request->type === 'solution') {
            $object = Solution::find($id);
        }

        $object->comment($message);
        $comments = $object->comments()->with('commentator')->get();

        if (Auth::user()->viaLoveReacter()->hasReactedTo($object)) {
            $object->liked = true;
        } else {
            $object->liked = false;
        }
        $object->comments = $comments;
        $object->comments_count = $object->comments()->count();
        $object->likes = $object->viaLoveReactant()->getReactionCounterOfType('Like')->getCount();

//        $member = User::find(Auth::user()->id);

        event(new CommentAdded($object, $object->author_id, 'Użytkownik skomentował : ' . $object->name, []));

        //        foreach ($comments as $comment) {
//            $comment->commentator = $comment->commentator;
//
//        }
        return response()->json([
            'success' => true,
            'message' => 'Skomentowano.',
            'payload' => $object
        ]);
    }
}
