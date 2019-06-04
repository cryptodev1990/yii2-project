<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\core\filters;

use yii\filters\AccessControl;
use yii\web\User;

/**
 * Custom AccessFilter to manage redirects if user access was denied
 * @package App\Core\Filters
 */
class AccessFilter extends AccessControl
{
    /**
     * Handles redirect
     *
     * @param false|\yii\web\User $user
     *
     * @return \yii\console\Response|\yii\web\Response
     * @throws \yii\web\ForbiddenHttpException
     */
    protected function denyAccess($user)
    {
        /** @var $user User */
        if ($user && $user->isGuest) {
            // if denied URL is not 'logout'
            if (request()->url !== '/logout') {
                // remember it to redirect after successful login
                $user->returnUrl = request()->url;
            }

            // call login action if current user is guest
            return $user->loginRequired();
        }

        // redirect logged user to home page
        return response()->redirect(
            app()->homeUrl
        );
    }
}