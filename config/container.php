<?php

use app\core\interfaces\MailerInterface;
use app\core\interfaces\StorageInterface;
use app\core\services\MailService;
use app\core\services\StorageService;

return [
    /**
     * DI Container definitions
     */
    'definitions' => [
        //'SomeClassInterface::class' => 'SomeClassImplementation::class',

        StorageInterface::class => [
            'class' => StorageService::class,
            'publicPath' => alias('@public'),
            'storagePath' => alias('@storage'),
        ],

        MailerInterface::class => MailService::class,
    ],
];