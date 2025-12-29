<?php

return [
    'change' => [
        'headline' => 'Passwort ändern',
        'cardHeadline' => 'Neues Passwort vergeben'
    ],
    'reset' => [
        'headline' => 'Passwort zurücksetzen',
        'back' => 'Zurück',
        'text' => 'Du hast dein Passwort vergessen und möchtest es zurücksetzen? Zum Zurücksetzen deines Passworts stehen dir die untenstehenden Möglichkeiten zur Verfügung. <br>Um die Zurücksetzung zu starten, wähle eine Möglichkeit aus.',
        'method' => [
            'email' => [
                'headline' => 'E-Mail-Adresse',
                'description' => 'Wir senden einen Zurücksetzungslink an eine private E-Mail-Adresse.',
                'text' => ' Sofern deine, oder die private E-Mail-Adresse eines Erziehungsberechtigten, bei uns hinterlegt ist, können wir dir eine E-Mail mit einem Zurücksetzungslink zusenden. Gib hierfür deinen Benutzernamen und die private E-Mail-Adresse unten an. Wenn deine Angaben korrekt sind, erhältst du den Link innerhalb weniger Minuten auf die angegebene E-Mail-Adresse. ',
                'invalidUsername' => 'Ungültiger Benutzername!',
                'invalidEmail' => 'Ungültige E-Mail-Adresse!',
            ],
            'teacher' => [
                'headline' => 'Durch eine Lehrkraft',
                'description' => 'Jede Lehrkraft kann dein Passwort zurücksetzen.',
                'text' => 'Jede Lehrkraft kann dein Passwort für dich zurücksetzen. Gehe hierzu z. B. in einer Pause zum Lehrerzimmer, klopfe und frage höflich, ob dir jemand helfen kann.'
            ]
        ],
        'init' => [
            'headline' => 'Vielen Dank!',
            'text' => 'Sofern deine Angaben korrekt sind, erhältst du in den nächsten Minuten auf der angegebenen E-Mail einen Zurücksetzungslink. Du kannst diese Seite nun schließen!',
        ]
    ]
];