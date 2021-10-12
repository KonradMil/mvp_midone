<?php

return [
    'error' => "Unexpected error occurred!",
    'save_correct' => "Saved correctly",
    'delete_correct' => "Delete correctly",
    'accepted' => 'Accepted',
    'rejected'=> 'Rejected',
    'canceled' => 'Canceled',
    'recaptcha_error' => 'Prove you are not a robot.',
    'no_permissions' => 'You are not permitted to make this action.',
    'email' => [
        'sending_fail' => 'Email could not be send.'
    ],
    'validation' => [
        'registration' => [
            'wrong_account_type' => "Incorrect account type"
        ]
    ],
    'registration' => [
        'account_created' => "Your account has been created! Please check your e-mail address and click on confirmation link.",
        'email_confirmed' => "Your account is active now.",
        'confirmation' => [
            'sent' => 'Please check your e-mail address and click on confirmation link.',
            'wrong_email' => "Given e-mail address doesn't exist in our database."
        ]
    ],
    'login' => [
        'wrong_credentials' => "Your login or password is incorrect.",
        'account_inactive' => "Your account has not been activated yet. Please check your e-mail and click on activation link.",
        'socialite' => [
            'wrong_provider' => "Login method is not allowed.",
            'nonexistent_account' => "There is no account with given e-mail address. Please sign up."
        ]
    ],
    'challenge' => [
        'not_found' => "Challenge not found.",
    ],
    'solution' => [
        'not_found' => "Solution not found.",
    ],
    'project' => [
        'not_found' => "Project not found.",
    ],
    'offer' => [
        'not_found' => "Offer not found",
    ],
    'file' => [
        'not_found' => "File not found",
    ],
    'user' => [
        'not_found' => "User not found",
    ],
    'team' => [
        'not_found' => "Team not found",
        'user_exists' => 'This user is already a member of this team.',
        'invitation' => [
            'exists' => 'This user is already invited.',
            'sent' => 'Invitation has been sent.',
            'claim' => [
                'team_not_found' => 'Team you were invited to does not exist.',
                'login_request' => 'Log in to accept the invitation.',
                'user_not_invited' => 'You cannot use someone else\'s team invitation.',
                'unexpected_error' => 'An error occurred while accepting the invitation. If the problem persists, contact the administrator.',
                'success' => 'The invitation to the team \":teamName\" has been accepted.'
            ]
        ],
    ]
];
