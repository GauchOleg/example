<?php
return [
    'login' => [
        'type' => 2,
    ],
    'logout' => [
        'type' => 2,
    ],
    'user' => [
        'type' => 1,
        'description' => 'Клиент',
        'children' => [
            'guest',
        ],
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Админ',
        'children' => [
            'PARTNER',
        ],
    ],
    'guest' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'login',
            'logout',
        ],
    ],
    'PARTNER' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'guest',
        ],
    ],
    'MOBILE_USER' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'guest',
        ],
    ],
];
