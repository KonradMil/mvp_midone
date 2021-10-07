<?php

namespace App\Http\Requests\Handlers;

use App\Parameters\ParametersInterface;
use App\Parameters\TeamInvitationParameters;

/**
 *
 */
class InviteUserToTeamHandler extends RequestHandler
{

    /**
     * @return ParametersInterface
     */
    public function getParameters(): ParametersInterface
    {
        $parameters = new TeamInvitationParameters();

        $parameters->email = (string)$this->request->get('email');
        $parameters->teamId = (int)$this->request->get('team_id');

        return $parameters;
    }

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
