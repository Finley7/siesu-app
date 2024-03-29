<?php

return [
    'status' => [
        'in_review' => 'In beoordeling',
        'in_progress' => 'In uitvoering',
        'to_verify' => 'Te verifiëren',
        'done' => 'Voltooid',
        'new' => 'Nieuw binnen'
    ],
    'manage' => [
        'flash' => [
            'success' => 'Succesvol beheerd.',
        ],
    ],
    'view' => [
        'back_to_summary' => 'Terug naar overzicht',
        'next_ticket' => 'Volgende ticket in de lijst',
        'author' => 'Aangemaakt door',
        'handler' => 'Uitvoerend medewerker',
        'help' => [
            'author' => 'plaatste dit ticket op',
        ],
        'created' => 'Aanmaakdatum',
        'manage' => [
            'title' => 'Beheren',
            'hard-delete' => 'Permanent verwijderen',
            'form' => [
                'label' => [
                    'status' => 'Status',
                    'handler' => 'Uitvoerend medewerker',
                    'author' => 'Auteur'
                ],
                'status' => [
                    'option' => [
                        'in_review' => 'In beoordeling',
                        'in_progress' => 'In uitvoering',
                        'to_verify' => 'Te verifiëren',
                        'done' => 'Voltooid',
                        'new' => 'Nieuw binnen'
                    ],
                ],
                'handler' => [
                    'option' => [
                        'default' => 'Selecteer medewerker'
                    ],
                ],
                'author' => [
                    'option' => [
                        'default' => 'Selecteer auteur'
                    ],
                ],
                'save' => 'Opslaan',
            ],
        ],
        'comment' => [
            'help' => [
                'author' => 'plaatste een reactie op',
            ],
            'form' => [
                'save' => 'Reactie opslaan'
            ]
        ],
        'media' => [
            'title' => 'Media',
            'empty' => 'Er is geen media bij dit ticket geupload.'
        ],
    ],
    'create' => [
        'title' => 'Nieuw ticket aanmaken',
        'form' => [
            'title' => 'Titel',
            'category' => 'Categorie',
            'select' => [
                'default' => 'Selecteer',
            ],
            'description' => 'Beschrijving',
            'create-button' => 'Aanmaken',
        ],
        'media' => [
            'title' => 'Media',
            'dropzone' => [
                'text' => 'Sleep bestanden hierheen of klik om te uploaden.',
            ],
        ],
    ],
    'index' => [
        'title' => 'Overzicht van tickets',
        'create-button' => 'Nieuw ticket',
        'table' => [
            'title' => 'Titel',
            'handler' => 'Behandelaar',
            'status' => 'Status',
            'date' => 'Datum',
            'last_response' => 'Recente reactie',
            'empty' => 'Er zijn geen openstaande tickets'
        ],
    ]

];
