<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class StudioController extends Controller
{
    public function challenge(int $challengeId): Factory|View|Application
    {
        $challenge = Challenge::find($challengeId);
        $user = Auth::user();

        if (!$challenge || $user->id !== $challenge->author_id && $user->type !== User::USER_TYPE_INTEGRATOR) {
            abort(404);
        }

        return view('app');
    }
}
