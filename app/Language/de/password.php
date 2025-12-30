<?php

return [
    'change' => [
        'headline' => 'Passwort ändern',
        'passwordMismatch' => 'Die eingegebenen Passwörter stimmen nicht überein.',
        'insufficientPassword' => 'Das gewählte Passwort entspricht den den Anforderungen.',
        'ldapError' => 'LDAP-Fehler: %s',
        'success' => 'Passwort erfolgreich geändert!'
    ],
    'reset' => [
        'headline' => 'Passwort zurücksetzen',
        'text' => 'Vergebe nun dein neues Passwort! Achte bitte darauf, dass es die Passwortanforderungen erfüllt.',
        'invalidToken' => 'Ungültiger Token! Bitte beachte, dass der Zurücksetzungslink nur für eine begrenzte Zeit gültig ist.',
        'passwordMismatch' => 'Die eingegebenen Passwörter stimmen nicht überein.',
        'insufficientPassword' => 'Das gewählte Passwort entspricht den den Anforderungen.',
        'ldapError' => 'LDAP-Fehler: %s',
        'start' => [
            'text' => 'Du hast dein Passwort vergessen und möchtest es zurücksetzen? Sofern deine, oder die private E-Mail-Adresse eines Erziehungsberechtigten, bei uns hinterlegt ist, können wir dir eine E-Mail mit einem Zurücksetzungslink zusenden. Gib hierfür deinen Benutzernamen und die private E-Mail-Adresse unten an. Wenn deine Angaben korrekt sind, erhältst du den Link innerhalb weniger Minuten auf die angegebene E-Mail-Adresse. ',
            'invalidUsername' => 'Ungültiger Benutzername!',
            'invalidEmail' => 'Ungültige E-Mail-Adresse!',
        ],
        'confirm' => [
            'headline' => 'Vielen Dank!',
            'text' => 'Sofern deine Angaben korrekt sind, erhältst du in den nächsten Minuten auf der angegebenen E-Mail einen Zurücksetzungslink. Du kannst diese Seite nun schließen!',
        ],
        'success' => [
            'headline' => 'Passwort geändert!',
            'text' => 'Dein Passwort wurde erfolgreich geändert.',
        ]
    ]
];