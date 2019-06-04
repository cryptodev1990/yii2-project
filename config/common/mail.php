<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

return [
    'class' => \yii\swiftmailer\Mailer::class,
    'viewPath' => '@resources/mail',
    'useFileTransport' => env('MAIL_DEBUG'),

    // disabled to enable Twig 'extends' tag
    'htmlLayout' => false,
    'textLayout' => false,

    'transport' => [
        'class' => Swift_SmtpTransport::class,
        'host' => env('MAIL_HOST'),
        'username' => env('MAIL_USER'),
        'password' => env('MAIL_PASSWORD'),
        'port' => env('MAIL_PORT'),
        'encryption' => env('MAIL_ENCRYPTION'),
    ],

    'view' => [
        'class' => \yii\web\View::class,
        'defaultExtension' => 'twig',
        'renderers' => [
            'twig' => require __DIR__ . '/twig.php',
        ],
    ],
];

