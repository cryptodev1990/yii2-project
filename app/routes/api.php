<?php

use manchenkov\yii\http\routing\Route;

// API module routes
return Route::group('api', 'api')->routes(
    [

        // Example Vue.js component route
        Route::get('get-text', 'example/load-text'),

    ]
);
