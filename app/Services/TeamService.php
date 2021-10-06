<?php

namespace App\Services;

use App\Models\Team;
use App\Models\TeamInvite;
use App\Models\User;
use App\Repository\Eloquent\TeamInviteRepository;
use App\Repository\Eloquent\TeamRepository;
use App\Repository\Eloquent\UserRepository;

class TeamService
{

    private UserRepository $userRepository;

    private TeamInviteRepository $teamInviteRepository;

    public function __construct(UserRepository $userRepository, TeamInviteRepository $teamInviteRepository)
    {
        $this->userRepository = $userRepository;
        $this->teamInviteRepository = $teamInviteRepository;
    }

    public function inviteUser(Team $team, $userEmail): TeamInvite
    {
        /** @var User $user */
        $user = $this->userRepository->findByEmail($userEmail);

        $invitationParameters = [
            'user_id' => $user->id ?? null,
            'team_id' => $team->id,
            'type' => TeamInvite::TYPE_INVITE,
            'email' => $userEmail,
            'accept_token' => md5(uniqid(microtime())),
            'deny_token' => md5(uniqid(microtime())),
        ];

        /** @var TeamInvite $teamInvitation */
        $teamInvitation = $this->teamInviteRepository->create($invitationParameters);



        return $teamInvitation;

    }

}
