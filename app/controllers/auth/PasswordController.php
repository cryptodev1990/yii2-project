<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\controllers\auth;

use app\core\interfaces\Mailer;
use manchenkov\yii\http\Controller;
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

        if ($form->load(request()->post())) {
            if ($form->validate() && $form->handle()) {
                return view('@views/site/notification', [
                    'icon' => 'email',
                    'title' => t('ui', 'title.great'),
                    'message' => t('ui', 'label.email-password-sent'),
                ]);
            }
        }

        return view('reset-password', compact('form'));
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

        if ($user) {
            $form = new SetPasswordForm();

            if ($form->load(request()->post())) {
                if ($form->validate() && $form->handle($user)) {
                    return view('@views/site/notification', [
                        'icon' => 'done',
                        'title' => t('ui', 'title.great'),
                        'message' => t('ui', 'label.email-password-changed'),
                    ]);
                }
            }

            return view('set-password', compact('form', 'token'));
        }

        return $this->goHome();
    }
}