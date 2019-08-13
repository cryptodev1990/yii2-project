<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\controllers\auth;

use app\core\interfaces\Mailer;
use app\extensions\http\Controller;
use app\forms\auth\ResetPasswordForm;
use app\forms\auth\SetPasswordForm;
use app\models\auth\User;
use yii\base\Exception;
use yii\web\Response;

class PasswordController extends Controller
{
    /**
     * Request a reset password link by user email
     *
     * @param Mailer $mailer
     *
     * @return string
     */
    public function actionResetPassword(Mailer $mailer)
    {
        $form = new ResetPasswordForm($mailer);
        $messageSent = false;

        if (request()->isPost && $form->load(request()->post())) {
            if ($form->validate()) {
                $messageSent = $form->handle();
            }
        }

        return view('reset-password', compact('form', 'messageSent'));
    }

    /**
     * Set new password for a user
     *
     * @param string $token
     *
     * @return string|Response
     * @throws Exception
     */
    public function actionSetPassword(string $token)
    {
        $user = User::findIdentityByAccessToken($token);
        $passwordChanged = false;

        if ($user) {
            $form = new SetPasswordForm();

            if (request()->isPost && $form->load(request()->post())) {
                if ($form->validate()) {
                    $passwordChanged = $form->handle($user);
                }
            }

            return view('set-password', compact('form', 'passwordChanged', 'token'));
        }

        return $this->redirect(['/']);
    }
}