<?php

return [
    'class' => 'yii\swiftmailer\Mailer',
    // send all mails to a file by default. You have to set
    // 'useFileTransport' to false and configure a transport
    // for the mailer to send real emails.
    'useFileTransport' => TRUE,
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => 'your host',
        'username' => 'your username',
        'password' => 'your password',
        'port' => '465',
        'encryption' => 'ssl',
    ],
];