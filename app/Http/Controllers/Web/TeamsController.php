<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\TeamInvite;
use App\Repository\Eloquent\TeamInviteRepository;
use App\Repository\Eloquent\TeamRepository;
use App\Services\TeamService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class TeamsController extends Controller
{

    /**
     * @param Request $request
     * @param TeamInviteRepository $teamInviteRepository
     * @param TeamRepository $teamRepository
     * @param TeamService $teamService
     * @return Redirector|Application|RedirectResponse
     */
    public function claimInvitation(
        Request              $request,
        TeamInviteRepository $teamInviteRepository,
        TeamRepository       $teamRepository,
        TeamService          $teamService
    ): Redirector|Application|RedirectResponse
    {
        $token = $request->get('token');

        /** @var TeamInvite|null $invitation */
        $invitation = $teamInviteRepository->findByAcceptToken($token);

        if (!$invitation) {
            return redirect('/login');
        }

        $user = Auth::user();

        $team = $teamRepository->find($invitation->team_id);

        if (!$team) {
            session()->flash(__('messages.team.invitation.claim.team_not_found'));
            return redirect($user ? '/dashboard' : '/login');
        }

        if (!$user) {
            session()->flash('info', __('messages.team.invitation.claim.login_request'));
            session()->put('teamInvitation', $token);
            return redirect('/login');
        }

        if ($user && $invitation->email !== $user->email) {
            session()->flash('error', __('messages.team.invitation.claim.user_not_invited'));
            return redirect('/dashboard');
        }

        $redirectTo = $request->get('redirect_to');

        try {
            $teamService->addUserToTeam($team->id, $user->id);
        } catch(\Exception $e) {

            session()->flash('error', __('messages.team.invitation.claim.unexpected_error'));
            if($redirectTo) {
                return redirect($redirectTo);
            }

            return redirect('/dashboard');
        }

        session()->remove('teamInvitation');
        session()->flash('success', __('messages.team.invitation.claim.success', ['teamName' => $team->name]));

        $invitation->delete();

        if($redirectTo) {
            return redirect($redirectTo);
        }

        return redirect('/dashboard');

    }

}
