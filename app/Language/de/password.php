<?php

return [
    'change' => [
        'headline' => 'Passwort ändern',
        'cardHeadline' => 'Neues Passwort vergeben'
    ],
    'reset' => [
        'headline' => 'Passwort zurücksetzen',
        'cardHeadline' => 'Wähle eine Zurücksetzungsmethode',
        'text' => 'Du hast dein Passwort vergessen und möchtest es zurücksetzen? Zum Zurücksetzen deines Passworts stehen dir die untenstehenden Möglichkeiten zur Verfügung. Um den Zurücksetzungsprozess zu starten, wähle eine der Möglichkeit aus.',
        'method' => [
            'email' => [
                'headline' => 'E-Mail-Adresse',
                'description' => 'Wir senden einen Link an deine hinterlegte private E-Mail-Adresse.'
            ],
            'parentEmail' => [
                'headline' => 'E-Mail-Adresse <br>deiner Eltern',
                'description' => 'Wir senden einen Link an eine hinterlegte E-Mail-Adresse deiner Eltern.'
            ],
            'teacher' => [
                'headline' => 'Durch eine Lehrkraft',
                'description' => 'Jede Lehrkraft kann dein Passwort zurücksetzen.'
            ]
        ]
    ]
];