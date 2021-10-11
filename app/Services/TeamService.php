<?php

namespace App\Services;

use App\Models\Team;
use App\Models\TeamInvite;
use App\Models\TeamUser;
use App\Models\User;
use App\Repository\Eloquent\TeamInviteRepository;
use App\Repository\Eloquent\TeamRepository;
use App\Repository\Eloquent\TeamUserRepository;
use App\Repository\Eloquent\UserRepository;

/**
 *
 */
class TeamService
{

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @var TeamInviteRepository
     */
    private TeamInviteRepository $teamInviteRepository;

    /**
     * @var TeamUserRepository
     */
    private TeamUserRepository $teamUserRepository;

    /**
     * @param UserRepository $userRepository
     * @param TeamInviteRepository $teamInviteRepository
     * @param TeamUserRepository $teamUserRepository
     */
    public function __construct(
        UserRepository       $userRepository,
        TeamInviteRepository $teamInviteRepository,
        TeamUserRepository   $teamUserRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->teamInviteRepository = $teamInviteRepository;
        $this->teamUserRepository = $teamUserRepository;
    }

    /**
     * @param Team $team
     * @param $userEmail
     * @return TeamInvite
     */
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

    /**
     * @param int $teamId
     * @param int $userId
     * @return TeamUser
     */
    public function addUserToTeam(int $teamId, int $userId): TeamUser
    {
        $parameters = [
            'user_id' => $userId,
            'team_id' => $teamId,
            'owner' => 0,
            'publishChallenge' => 1,
            'acceptChallengeSolution' => 0,
            'acceptChallengeOffer' => 0,
            'publishSolution' => 0,
            'addSolutionOffer' => 0,
            'canEditSolution' => 0,
            'canDeleteSolution' => 0,
            'showSolution' => 1
        ];

        /** @var TeamUser $teamUser */
        $teamUser = $this->teamUserRepository->create($parameters);

        return $teamUser;

    }

}
