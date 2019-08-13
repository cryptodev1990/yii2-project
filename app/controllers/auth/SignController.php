<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\controllers\auth;

use app\core\filters\AccessFilter;
use app\core\interfaces\Mailer;
use app\extensions\http\Controller;
use app\forms\auth\LoginForm;
use app\forms\auth\SignUpForm;
use app\models\auth\AuthClient;
use app\models\auth\User;
use yii\authclient\AuthAction;
use yii\base\Exception;
use yii\web\Response;

class SignController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessFilter::class,
                'rules' => $this->accessRules(),
            ],
        ];
    }

    /**
     * Social authentication action with callback
     * @return array
     */
    public function actions()
    {
        return [
            'social-auth' => [
                'class' => AuthAction::class,
                'successCallback' => [AuthClient::class, 'onAuthSuccess'],
            ],
        ];
    }

    /**
     * @return array
     */
    private function accessRules()
    {
        return [
            [
                'actions' => ['login', 'sign-up', 'social-auth'],
                'allow' => true,
                'roles' => ['?'],
            ],
            [
                'actions' => ['logout'],
                'allow' => true,
                'roles' => ['@'],
            ],
        ];
    }

    /**
     * "Sign in" user action
     * @return string|Response
     */
    public function actionLogin()
    {
        $form = new LoginForm();

        if ($form->load(request()->post()) && $form->validate()) {
            // try to load and authorize user
            if ($user = $form->handle()) {
                return $user->login();
            }
        }

        return view('login', compact('form'));
    }

    /**
     * "Sign up" user action
     *
     * @param Mailer $mailer
     *
     * @return string|\yii\console\Response|Response
     * @throws Exception
     */
    public function actionSignUp(Mailer $mailer)
    {
        $form = new SignUpForm($mailer);

        if ($form->load(request()->post()) && $form->validate()) {
            // try to register a user
            if ($user = $form->handle()) {
                return $user->login(true);
            } else {
                session()->addFlash(
                    'errors',
                    t('errors', 'auth.register-error')
                );
            }
        }

        return view('sign-up', compact('form'));
    }

    /**
     * User E-mail activation link
     *
     * @param string $token
     *
     * @return Response
     * @throws Exception
     */
    public function actionActivate(string $token)
    {
        // find a user by token value
        $user = User::findIdentityByAccessToken($token);

        if ($user) {
            // log out current user
            if (!user()->isGuest) {
                user()->logout();
            }

            if ($user->activate()) {
                // login as the user and show registration page
                $user->login();

                return view('activated');
            }
        }

        return $this->goHome();
    }

    /**
     * "Sign out" user action
     * @return Response
     */
    public function actionLogout()
    {
        user()->logout();

        return $this->goHome();
    }
}