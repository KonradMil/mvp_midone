<?php

namespace App\Http\Controllers;

use App\Models\Challenges\Challenge;
use App\Models\Knowledgebase\KnowledgeBaseVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KnowledgebaseController extends Controller
{
    public function getPosts(Request $request)
    {
        $input = $request->input();
        $query = KnowledgeBaseVideo::query();
        if(isset($input->search)){
            $query->where('name', '=', $input->search);
        }
        if(isset($input->search)){
            $query->where('category', '=', $input->category);
        }
        $posts = $query->with('comments', 'comments.commentator')->get();
        foreach ($posts as $post) {
            if(Auth::user()->viaLoveReacter()->hasReactedTo($post)){
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

    public function addPost(Request $request)
    {
        $input = $request->input('data');

        $post = new KnowledgeBaseVideo();
        $post->src = 'https://www.youtube.com/embed/' . $input['youtube'];
        $post->name = $input['name'];
        $post->description = $input['description'];
        $post->category = $input['category'];
        $post->poster = 'http://img.youtube.com/vi/' . $input['youtube'] .'/hqdefault.jpg';
        $post->published = (int)$input['published'];
        $post->save();

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $post
        ]);
    }

    public function editPost(Request $request)
    {

    }

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
