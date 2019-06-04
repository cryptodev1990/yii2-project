<?php
/**
 * Created by Artem Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

/**
 * Application parameters (You may use simple env() function)
 */
return [
    'email.admin' => env('MAIL_ADMIN'),
    'email.support' => env('MAIL_SUPPORT'),
    'email.no-reply' => env('MAIL_NOTIFY'),

    'user.loginSessionTime' => 3600 * 24 * 30, // 1 month
    'user.passwordResetTokenExpire' => 3600,

    'reCAPTCHA.siteKey' => env('GOOGLE_RECAPTCHA_SITE_KEY'),
    'reCAPTCHA.secretKey' => env('GOOGLE_RECAPTCHA_SECRET_KEY'),
];

