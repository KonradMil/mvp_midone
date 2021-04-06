<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Mail\TeamInvitation;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Mpociot\Teamwork\Facades\Teamwork;
use Mpociot\Teamwork\TeamInvite;

class TeamsController extends Controller
{
    public function getUserTeamsFiltered(Request $request)
    {
        $input = $request->input();
//        dd(Auth::user()->ownedTeams);
        if (!empty($input->search)) {
            $query = Auth::user()->teams()->where('name', 'LIKE', '%' . $input->search . '%')->with('users', 'users.companies')->get();
//            $queryForeign = Auth::user()->ownedTeams->where('name', 'LIKE', '%' . $input->search . '%')->get();
        } else {
            $query = Auth::user()->teams()->with('users', 'users.companies')->get();
//            $queryForeign = Auth::user()->ownedTeams;
        }

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $query
        ]);
    }

    public function createTeam(Request $request)
    {
        $name = $request->input('name');
        $team = new Team();
        $team->owner_id = Auth::user()->id;
        $team->name = $name;
        $team->save();
        dd($team);
        Auth::user()->attachTeam($team);

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $team
        ]);
    }

    public function addUserToTeam(Request $request)
    {
        $team_id = $request->input('team_id');
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        $user->attachTeam($team_id);

        return response()->json([
            'success' => true,
            'message' => 'Dodano poprawnie.',
            'payload' => []
        ]);
    }

    public function inviteUser(Request $request)
    {

        $team = Team::find($request->team_id);
        $user = User::where('email', '=', $request->email)->first();
        if ($user != null) {
            $check = 0;
            foreach ($user->teams as $teamm) {
                if ($teamm->id == $request->team_id) {
                    $check = 1;
                }
            }
            if ($check !== 0) {
                //USER ALREADY IN TEAM
            }
        }

        if (!Teamwork::hasPendingInvite($request->email, $request->team_id)) {
            Teamwork::inviteToTeam($request->email, $request->team_id, function ($invite) use ($team, $user) {
                if ($user != null) {
                    $user->notify(new \App\Notifications\TeamInvitation($invite, $team->name));
                } else {
                    Mail::to($invite->email)->send(new TeamInvitation($invite, $team->name));
                }
            });
        } else {
            // Return error - user already invited
        }
    }

    public function getUserInvites()
    {
        $invites = Auth::user()->invites()->with('team', 'inviter')->get();

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $invites
        ]);
    }

    public function acceptInvite(Request  $request)
    {
        $invite = TeamInvite::find($request->id);
        Teamwork::acceptInvite( $invite );
//        $team = $invite->team;
//        $invite->delete();
//        Auth::user()->attachTeam($team);

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => []
        ]);
    }
}
