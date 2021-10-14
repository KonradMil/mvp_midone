<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\KnowledgeBaseVideo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class KnowledgebaseController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getPosts(Request $request)
    {
        $input = $request->input();
        $query = KnowledgeBaseVideo::query();
        if (isset($input->search)) {
            $query->where('name', '=', $input->search);
        }
        if (isset($input->search)) {
            $query->where('category', '=', $input->category);
        }
        $posts = $query->with('comments', 'comments.commentator')->get();
        foreach ($posts as $post) {
            if (Auth::user()->viaLoveReacter()->hasReactedTo($post)) {
                $post->liked = true;
            } else {
                $post->liked = false;
            }
            $post->comments_count = $post->comments()->count();
            $post->likes = $post->viaLoveReactant()->getReactionCounterOfType('Like')->getCount();
        }
        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $posts
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addPost(Request $request)
    {
        $input = $request->input('data');

        $post = new KnowledgeBaseVideo();
        $post->src = 'https://www.youtube.com/embed/' . $input['youtube'];
        $post->name = $input['name'];
        $post->description = $input['description'];
        $post->category = $input['category'];
        $post->poster = 'http://img.youtube.com/vi/' . $input['youtube'] . '/hqdefault.jpg';
        $post->published = (int)$input['published'];
        $post->video_id = $input['youtube'];
        $post->save();

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $post
        ]);
    }

    /**
     * @param Request $request
     */
    public function editPost(Request $request)
    {

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function likePost(Request $request)
    {
        $id = $request->input('id');
        $post = KnowledgeBaseVideo::find($id);
        Auth::user()->viaLoveReacter()->reactTo($post, 'Like');

        return response()->json([
            'success' => true,
            'message' => 'Polajkowano.',
            'payload' => ''
        ]);
    }
}
