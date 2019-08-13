<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

use app\extensions\http\routing\Router;

return [
    // Basic website routes
    Router::get('/', 'site/index'),
    Router::any('me', 'home/me')->name('me'),

    // Auth section
    Router::group('/', 'auth')->routes([
        Router::any('login', 'sign/login')->name('login'),
        Router::get('logout', 'sign/logout')->name('logout'),
        Router::any('sign-up', 'sign/sign-up')->name('sign-up'),
        Router::get('auth/activate-user', 'sign/activate'),
        Router::any('auth/reset-password', 'password/reset-password')->name('reset-password'),
        Router::any('auth/set-password', 'password/set-password')->name('set-password'),
        Router::get('social-auth/<authclient>', 'sign/social-auth')->name('social.client'),
    ]),

    // Example Vue.js component route
    Router::get('api/get-text', 'api/example/load-text'),
];

