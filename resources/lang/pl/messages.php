<?php

return [
    'unfollow' => "Przestałeś obserwować",
    'error' => "Wystąpił nieoczekiwany błąd!!",
    'save_correct' => "Zapisano poprawnie",
    'delete_correct' => "Usunięto poprawnie",
    'accepted' => 'Zaakceptowano',
    'rejected'=> 'Odrzucono',
    'canceled' => 'Odwołano',
    'recaptcha_error' => 'Udowodnij że nie jesteś robotem.',
    'no_permissions' => 'Nie posiadasz wystarczających uprawnień, aby wykonać tą akcję.',
    'email' => [
        'sending_fail' => 'Wiadomość e-mail nie mogła zostać wysłana.'
    ],
    'validation' => [
        'registration' => [
            'wrong_account_type' => "Nieprawidłowy typ konta."
        ]
    ],
    'registration' => [
        'account_created' => "Twoje konto zostało utworzone! Na twój adres e-mail został wysłany link aktywacyjny w celu potwierdzenia.",
        'email_confirmed' => "Twoje konto zostało aktywowane.",
        'confirmation' => [
            'sent' => 'Na twój adres e-mail został wysłany link aktywacyjny w celu potwierdzenia.',
            'wrong_email' => "Podany adres e-mail nie istnieje."
        ]
    ],
    'login' => [
        'wrong_credentials' => "Nieprawidłowy adres e-mail lub hasło.",
        'account_inactive' => "Twoje konto jest nieaktywne. Sprawdź swóją skrzynkę e-mail, a następnie kliknij w link aktywacyjny.",
        'socialite' => [
            'wrong_provider' => "Niedozwolona metoda logowania.",
            'nonexistent_account' => "Konto o podanym adresie e-mail nie istnieje. Zarejestruj się."
        ]
    ],
    'challenge' => [
        'not_found' => "Wyzwania nie znaleziono.",
    ],
    'solution' => [
        'not_found' => "Rozwiązania nie znaleziono.",
    ],
    'project' => [
        'not_found' => "Projektu nie znaleziono.",
    ],
    'offer' => [
        'not_found' => 'Oferty nie znaleziono'
    ],
    'user' => [
        'not_found' => "Użytkownika nie znaleziono",
    ],
    'file' => [
        'not_found' => "Pliku nie znaleziono",
    ],
    'team' => [
        'not_found' => "Nie znaleziono zespołu.",
        'user_exists' => 'Ten użytkownik jest już członkiem Twojego zespołu.',
        'invitation' => [
            'exists' => 'Już zaprosiłeś tego użytkownika.',
            'sent' => 'Zaproszenie do zespołu zostało wysłane.',
            'claim' => [
                'team_not_found' => 'Zespół, do którego otrzymałeś zaproszenie nie istnieje.',
                'login_request' => 'Zaloguj się, aby przyjąć zaproszenie.',
                'user_not_invited' => 'Nie możesz skorzystać z cudzego zaproszenia do zespołu.',
                'unexpected_error' => 'Wystąpił błąd podczas przyjęcia zaproszenia. Jeśli problem będzie się powtarzał skontaktuj się z administratorem.',
                'success' => 'Zaproszenie do zespołu \":teamName\" zostało przyjęte.'
            ]
        ],
    ]
];
