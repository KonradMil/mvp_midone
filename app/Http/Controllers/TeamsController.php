<?php

namespace App\Http\Controllers;


use App\Mail\TeamInvitation;
use App\Models\Challenge;
use App\Models\Solution;
use App\Models\Team;
use App\Models\TeamUser;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Mpociot\Teamwork\Facades\Teamwork;
use Mpociot\Teamwork\TeamInvite;

/**
 *
 */
class TeamsController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveMemberPermission(Request $request): JsonResponse
    {
        $team = Team::find($request->input('team_id'));
        $member = User::find($request->input('member_id'));
//        $team_user = TeamUser::where('user_id', '=', $member->id)->where('team_id', '=', $team->id)->first();

        $team_user = $member->teams()->where(['team_id' => $team->id, 'user_id' => $member->id])->first(); //get the first record

//        $team_user->pivot->publishChallenge = 0;

//        $team_user->pivot->save();

        if ($team_user != NULL) {
            $team_user->pivot->publishChallenge = $request->input('publishChallenge');
            $team_user->pivot->editChallenge = $request->input('editChallenge');
            $team_user->pivot->publishSolution = $request->input('publishSolution');
            $team_user->pivot->canEditSolution = $request->input('canEditSolution');
            $team_user->pivot->canDeleteSolution = $request->input('canDeleteSolution');
            $team_user->pivot->acceptChallengeOffer = $request->input('acceptChallengeOffer');
            $team_user->pivot->addSolutionOffer = $request->input('addSolutionOffer');
            $team_user->pivot->acceptChallengeSolution = $request->input('acceptChallengeSolution');
            $team_user->pivot->save();
        }

//        $teams = $member->teams()->where('id', '=', $team->id);
        return response()->json([
            'success' => true,
            'message' => 'Zapisano uprawnienia!',
            'payload' => $team_user
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getMemberPermission(Request $request): JsonResponse
    {
        $team = Team::find($request->input('team_id'));
        $member = User::find($request->input('member_id'));
        $team_user = TeamUser::where('user_id', '=', $member->id)->where('team_id', '=', $team->id)->first();
//        $teams = $member->teams()->where('id', '=', $team->id);
        return response()->json([
            'success' => true,
            'message' => 'Pobrano uprawnienia!',
            'payload' => $team_user
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addObjectTeam(Request $request): JsonResponse
    {
        $name = $request->input('name');
        $team = new Team();
        $team->owner_id = Auth::user()->id;
        $team->name = $name;
        $team->save();
        Auth::user()->teams()->attach($team, ['owner' => false, 'publishChallenge' => false, 'acceptChallengeSolution' => false, 'acceptChallengeOffer' => false, 'publishSolution' => false, 'canEditSolution' => false, 'canDeleteSolution' => false, 'addSolutionOffer' => false, 'showSolutions' => true]);
        $who = $request->input('who');
        $id = $request->input('id');
        if ($who == 'challenge') {
            $challenge = Challenge::find($id);
            $challenge->teams()->attach($team);
            $challenge->save();
        } else {
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getUserTeamsFiltered(Request $request): JsonResponse
    {
        $input = $request->input();
//        dd(Auth::user()->ownedTeams);
        $who = $request->input('who');
        $array = [];
        if ($who === 'solution') {
            $solution = Solution::find($request->input('id'));
            $teams = $solution->teams;
            foreach ($teams as $team) {
                $array[] = $team->id;
            }
        } else if ($who === 'challenge') {
            $challenge = Challenge::find($request->input('id'));
            $teams = $challenge->teams;
            foreach ($teams as $team) {
                $array[] = $team->id;
            }
        }
        if (!empty($input->search)) {
            $query = Auth::user()->teams()->where('name', 'LIKE', '%' . $input->search . '%')->whereNotIn('id', $array)->with('users', 'users.companies')->get();
//            $queryForeign = Auth::user()->ownedTeams->where('name', 'LIKE', '%' . $input->search . '%')->get();
        } else {
            $query = Auth::user()->teams()->with('users', 'users.companies')->whereNotIn('id', $array)->get();
//            $queryForeign = Auth::user()->ownedTeams;
        }

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $query,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createTeam(Request $request): JsonResponse
    {
        $name = $request->input('name');
        $team = new Team();
        $team->owner_id = Auth::user()->id;
        $team->name = $name;
        $team->save();

        if (Auth::user()->type === 'investor') {
            Auth::user()->teams()->attach($team, ['owner' => true, 'publishChallenge' => false, 'editChallenge' => false, 'acceptChallengeSolution' => false, 'acceptChallengeOffer' => false, 'publishSolution' => false, 'canEditSolution' => false, 'canDeleteSolution' => false, 'addSolutionOffer' => false]);

        } else if (Auth::user()->type === 'integrator') {
            Auth::user()->teams()->attach($team, ['owner' => true, 'publishChallenge' => false, 'editChallenge' => false, 'acceptChallengeSolution' => false, 'acceptChallengeOffer' => false, 'publishSolution' => false, 'canEditSolution' => false, 'canDeleteSolution' => false, 'addSolutionOffer' => false, 'showSolutions' => true]);
        }
        $t = Team::where('id', '=', $team->id)->with('users', 'users.companies')->first();
//        dd($team);

//        $team->users = $team->users;

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $t
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteTeam(Request $request): JsonResponse
    {
        $team = Team::find($request->input('team_id'));
        $team_invites = TeamInvite::where('team_id', '=', $team->id);
        foreach ($team_invites as $ti) {
            $ti->delete();
        }
        if ($team != NULL) {
            foreach ($team->users as $user) {
                $user->teams()->detach($team);
            }
            $team->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Usunięto poprawnie',
            'payload' => $team_invites
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteMember(Request $request): JsonResponse
    {
        $team = Team::find($request->team_id);
        $owner = Auth::user();
        if ($owner->id === $team->owner_id) {
            $user = User::where('id', '=', $request->member_id)->first();
            if ($owner->id != $user->id) {
                $team->users()->detach($user);
                $team->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Usunięto poprawnie!',
                    'payload' => []
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Nie możesz usunąć samego siebie z zespołu!',
                    'payload' => []
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Brak uprawnień!',
                'payload' => []
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addUserToTeam(Request $request): JsonResponse
    {
        $team_id = $request->input('team_id');
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        $team = Team::find($team_id);
        $check = User::find($team->owner_id);
        if ($check->type === 'investor') {
            $user->attachTeam($team_id, ['owner' => false, 'publishChallenge' => false, 'editChallenge' => false, 'acceptChallengeSolution' => false, 'acceptChallengeOffer' => false, 'publishSolution' => false, 'addSolutionOffer' => false, 'canEditSolution' => false, 'canDeleteSolution' => false]);
        } else if ($check->type === 'integrator') {
            $user->attachTeam($team_id, ['owner' => false, 'publishChallenge' => false, 'editChallenge' => false, 'acceptChallengeSolution' => false, 'acceptChallengeOffer' => false, 'publishSolution' => false, 'addSolutionOffer' => false, 'canEditSolution' => false, 'canDeleteSolution' => false, 'showSolutions' => true]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Dodano poprawnie.',
            'payload' => []
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse|void
     */
    public function inviteUser(Request $request)
    {

        $team = Team::find($request->team_id);
        $user = User::where('email', '=', $request->email)->first();
        foreach ($team->users as $member) {
            if ($member->email === $user->email) {

            }

        }

        if ($user != null) {
            $check = 0;
            foreach ($user->teams as $teamm) {
                if ($teamm->id == $request->team_id) {
                    $check = 1;
                }
            }
            if ($check !== 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Użytkownik jest już w zespole!.',
                    'payload' => []
                ]);
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

    /**
     * @return JsonResponse
     */
    public function getUserInvites(): JsonResponse
    {
//        $invites = Auth::user()->invites()->with('team', 'inviter')->get();
        $invites = TeamInvite::where('email', '=', Auth::user()->email)->with('team', 'inviter', 'user')->get();
        $invitesSent = TeamInvite::where('user_id', '=', Auth::user()->id)->with('team', 'inviter', 'user')->get();
        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $invites,
            'sent' => $invitesSent
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function acceptInvite(Request $request): JsonResponse
    {
        $invite = TeamInvite::find($request->id);
        $team = Team::find($invite->team_id);
//        $user = User::find($invite->user_id);
        $user = User::where('email', '=', $invite->email)->first();
        $check = User::find($team->owner_id);
        if ($check->type === 'investor') {
            $user->teams()->attach($team, ['owner' => false, 'publishChallenge' => false, 'editChallenge' => false, 'acceptChallengeSolution' => false, 'acceptChallengeOffer' => false, 'publishSolution' => false, 'addSolutionOffer' => false, 'canEditSolution' => false, 'canDeleteSolution' => false]);
        } else if ($check->type === 'integrator') {
            $user->teams()->attach($team, ['owner' => false, 'publishChallenge' => false, 'editChallenge' => false, 'acceptChallengeSolution' => false, 'acceptChallengeOffer' => false, 'publishSolution' => false, 'addSolutionOffer' => false, 'canEditSolution' => false, 'canDeleteSolution' => false, 'showSolutions' => true]);
        }
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addToSelected(Request $request): JsonResponse
    {
        $input = $request->input();
        if ($input['type'] == 'challenge') {
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function removeFromSelected(Request $request): JsonResponse
    {
        $input = $request->input();
        if ($input['type'] == 'challenge') {
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
