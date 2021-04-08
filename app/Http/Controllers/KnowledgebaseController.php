<?php

namespace App\Http\Controllers;

use App\Models\Challenges\Challenge;
use App\Models\Knowledgebase\KnowledgeBaseVideo;
use Illuminate\Http\Request;

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
        $posts = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $posts
        ]);
    }

    public function addPost(Request $request)
    {
        $input = $request->input();
        $post = new KnowledgeBaseVideo();
        $post->src = 'https://www.youtube.com/embed/' . $input->youtube;
        $post->name = $input->name;
        $post->description = $input->description;
        $post->category = $input->category;
        $post->poster = 'http://img.youtube.com/vi/' . $input->youtube .'/hqdefault.jpg';
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
}
