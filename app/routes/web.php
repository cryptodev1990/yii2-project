<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

use app\extensions\http\routing\Route;

return [

    // Basic website routes
    Route::get('/', 'site/index'),
    Route::any('me', 'home/me')->name('me'),

    // Auth section
    Route::group('/', 'auth')->routes([
        Route::any('login', 'sign/login')->name('login'),
        Route::get('logout', 'sign/logout')->name('logout'),
        Route::any('sign-up', 'sign/sign-up')->name('sign-up'),
        Route::get('auth/activate-user', 'sign/activate'),
        Route::any('auth/reset-password', 'password/reset-password')->name('reset-password'),
        Route::any('auth/set-password', 'password/set-password')->name('set-password'),
        Route::get('social-auth/<authclient>', 'sign/social-auth')->name('social.client'),
    ]),

];

