<?php
/**
 * Created by Artem Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

use app\core\interfaces\Mailer;
use app\core\interfaces\Storage;
use app\core\services\MailService;
use app\core\services\StorageService;

return [
    /**
     * DI Container definitions
     */
    'definitions' => [
        //'SomeClassInterface::class' => 'SomeClassImplementation::class',

        Storage::class => [
            'class' => StorageService::class,
            'publicPath' => alias('@public'),
            'storagePath' => alias('@storage'),
        ],

        Mailer::class => MailService::class,
    ],
];