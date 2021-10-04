<?php

return [
    'recaptcha_error' => 'Prove you are not a robot.',
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
    ]
];
