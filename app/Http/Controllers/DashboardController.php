<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Solutions\Solution;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    public function getDataForDashboard()
    {
        $logs = Activity::where('subject_type', '=', 'App\\Models\\Challenges\\Challenge')->where('description', 'LIKE', '*opublikowane*')->take(10)->get();
        $posts = Post::where('status', '=', 'publish')->orderBy('created_at', 'DESC')->take(10)->get();
        $solutions = Solution::query()
            ->where('status', '=', '1')->orWhere('published', '=', 1)
            ->joinReactionCounterOfType('Like')
            ->orderBy('reaction_like_count', 'desc')
            ->with('author', 'challenge')
            ->take(10)
            ->get();
        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie',
            'payload' => [
                'posts' => $posts,
                'solutions' => $solutions,
                'logs' => $logs
            ]
        ]);
    }
}
