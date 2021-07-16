<?php

namespace App\Http\Controllers\Crud;

use App\Events\TeamMemberAccepted;
use App\Http\Controllers\Controller;
use App\Mail\TeamInvitation;
use App\Models\Challenges\Challenge;
use App\Models\Solutions\Solution;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Mpociot\Teamwork\Facades\Teamwork;
use Mpociot\Teamwork\TeamInvite;

class TeamsController extends Controller
{
    public function addObjectTeam(Request $request)
    {
        $name = $request -> input('name');
        $team = new Team();
        $team-> owner_id = Auth::user()->id;
        $team-> name = $name;
        $team->save();
        Auth::user()->teams()->attach($team, ['owner'=> true, 'publishChallenge' => true, 'acceptChallengeSolution' => true, 'acceptChallengeOffer' => true, 'publishSolution' => true, 'addSolutionOffer' => true]);
        $who = $request -> input('who');
        $id = $request -> input('id');
        if($who == 'challenge')
        {
            $challenge = Challenge::find($id);
            $challenge->teams()->attach($team);
            $challenge->save();
        }
        else
        {
            $solution = Solution::find($id);
            $solution->teams()->attach($team);
            $solution->save();
        }

        $t = Team::where('id', '=', $team->id)->with('users', 'users.companies')->first();

        return response()->json([
            'success' => true,
            'message' => 'Dodano zespół!',
            'payload' => $t
        ]);
    }
    public function getUserTeamsFiltered(Request $request)
    {
        $input = $request->input();
        $who = $request->input('who');
//        dd(Auth::user()->ownedTeams);
        if (!empty($input->search)) {
            $query = Auth::user()->teams()->where('name', 'LIKE', '%' . $input->search . '%')->with('users', 'users.companies')->get();
//            $queryForeign = Auth::user()->ownedTeams->where('name', 'LIKE', '%' . $input->search . '%')->get();
        } else {
            $query = Auth::user()->teams()->with('users', 'users.companies')->get();

            //            $queryForeign = Auth::user()->ownedTeams;
        }

        if($who === 'solution'){
            $solution = Solution::find($request->input('id'));
            $currentTeams = $solution->teams;
        }else{
            $challenge = Challenge::find($request->input('id'));
            $currentTeams = $challenge->teams;
        }

        foreach($query as $t){
            foreach($currentTeams as $cT){
                if($cT->id == $t->id){
                    $query->t->delete();
                }
            }
        }

        foreach ($query as $t){
            dump($t->pivot);
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
        Auth::user()->attachTeam($team, ['owner'=> true, 'publishChallenge' => true, 'acceptChallengeSolution' => true, 'acceptChallengeOffer' => true, 'publishSolution' => true, 'addSolutionOffer' => true]);
        $t = Team::where('id', '=', $team->id)->with('users', 'users.companies')->first();
//        dd($team);

//        $team->users = $team->users;

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $t
        ]);
    }
    public function deleteTeam(Request $request)
    {
        Team::destroy($request->id);

        return response()->json([
            'success' => true,
            'message' => 'Usunięto poprawnie',
        ]);
    }
    public function deleteMember(Request $request)
    {
        $team = Team::find($request->team_id);
        $owner = Auth::user();
        if($owner->id === $team->owner_id)
        {
            $user = User::where('id', '=', $request->member_id)->first();
            if($owner->id != $user->id)
            {
                $team -> users()->detach($user);
                $team->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Usunięto poprawnie!',
                    'payload' => []
                ]);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Nie możesz usunąć samego siebie z zespołu!',
                    'payload' => []
                ]);
            }
        }
        else {
            return response()->json([
                'success' => false,
                'message' => 'Brak uprawnień!',
                'payload' => []
            ]);
        }
    }

    public function addUserToTeam(Request $request)
    {
        $team_id = $request->input('team_id');
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        $user->attachTeam($team_id, ['owner'=> true, 'publishChallenge' => true, 'acceptChallengeSolution' => true, 'acceptChallengeOffer' => true, 'publishSolution' => true, 'addSolutionOffer' => true]);

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
        $invitesSent = TeamInvite::where('user_id', '=', Auth::user()->id)->with('team', 'inviter', 'user')->get();
        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $invites,
            'sent' => $invitesSent
        ]);
    }

    public function acceptInvite(Request  $request)
    {
        $invite = TeamInvite::find($request->id);

        $user = User::find($invite->user_id);
        $user->teams()->attach($invite->team, ['owner'=> true, 'publishChallenge' => true, 'acceptChallengeSolution' => true, 'acceptChallengeOffer' => true, 'publishSolution' => true, 'addSolutionOffer' => true]);
        $team = Team::find($invite->team_id);
          $invite->delete();
//        $team = $invite->team;

//        event(new TeamMemberAccepted($team, $user, 'Użytkownik zaakceptował Twoje zaproszenie do zespołu!: ' . $team->name, []));

//        $team = $invite->team;
//        $invite->delete();
//        Auth::user()->attachTeam($team);

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $team,
        ]);
    }

    public function addToSelected(Request $request)
    {
        $input = $request->input();
        if($input['type'] == 'challenge') {
            $object = Challenge::find($input['object_id']);
        } else if ($input['type'] == 'solution') {
            $object = Solution::find($input['object_id']);
        }

        $object->teams()->attach($input['team_id']);
        $team = Team::with('users', 'users.companies')->find($input['team_id']);
        return response()->json([
            'success' => true,
            'message' => 'Dodano poprawnie.',
            'payload' => $team
        ]);
    }

    public function removeFromSelected(Request $request)
    {
        $input = $request->input();
        if($input['type'] == 'challenge') {
            $object = Challenge::find($input['object_id']);
        } else if ($input['type'] == 'solution') {
            $object = Solution::find($input['object_id']);
        }

        $object->teams()->detach($input['team_id']);

        return response()->json([
            'success' => true,
            'message' => 'Rozłączono poprawnie.',
            'payload' => []
        ]);
    }
}
