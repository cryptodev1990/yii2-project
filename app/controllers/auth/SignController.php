<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\controllers\auth;

use app\core\filters\AccessFilter;
use app\core\interfaces\ACL;
use app\core\interfaces\Sender;
use app\extensions\http\Controller;
use app\forms\auth\LoginForm;
use app\forms\auth\SignUpForm;
use app\models\auth\AuthClient;
use app\models\auth\User;
use Exception;
use yii\authclient\AuthAction;
use yii\authclient\ClientInterface;
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
                'successCallback' => [$this, 'handleSocialAuth'],
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
        // create a new form for authentication
        $form = new LoginForm();

        // check data from POST request
        if (request()->isPost && $form->load(request()->post())) {
            // form validation
            if ($form->validate()) {
                // try to load and authorize user
                $user = $form->handle();

                if ($user) {
                    return $user->login();
                }
            }
        }

        return view('login', compact('form'));
    }

    /**
     * "Sign up" user action
     *
     * @param Sender $mailer
     *
     * @return string|\yii\console\Response|Response
     * @throws \yii\base\Exception
     * @throws Exception
     */
    public function actionSignUp(Sender $mailer)
    {
        // create a new form for user registration
        $form = new SignUpForm();

        // check loading data from request
        if (request()->isPost && $form->load(request()->post())) {
            // form validation
            if ($form->validate()) {
                // try to register a user
                if ($user = $form->handle($mailer)) {
                    // assign base RBAC role
                    auth()->assign(
                        auth()->getRole('user'),
                        $user->id
                    );

                    return $user->login(true);
                } else {
                    // set error if register wasn't success
                    session()->addFlash(
                        'errors',
                        t('errors', 'auth/register-error')
                    );
                }
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
     * @throws \yii\base\Exception
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

            // activate founded user account
            $user->is_active = true;
            $user->generateToken();

            if ($user->save()) {
                // login as the user and show registration page
                $user->login();

                return view('activated');
            }
        }

        return $this->redirect(['/']);
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

    /**
     * Handler for social auth clients
     *
     * @param ClientInterface $client
     *
     * @return Response|null
     * @throws \yii\base\Exception
     * @throws Exception
     */
    public function handleSocialAuth(ClientInterface $client)
    {
        // get information about user from external service
        $userData = AuthClient::parseUserDetails($client);

        // search existing auth client item
        $authClient = AuthClient::findOne([
            'source' => $client->getId(),
            'source_id' => $userData['id'],
        ]);

        // if guest - try to login/register
        if (user()->isGuest) {
            if ($authClient) {
                // login if exists
                return $authClient->user->login();
            } else {
                // find existing user
                $user = User::findOne(['email' => $userData['email']]);

                if ($user) {
                    // email already registered without social networks
                    session()->addFlash(
                        'errors', t('errors', 'auth/user-already-exists')
                    );
                } else {
                    $user = new User([
                        'first_name' => $userData['first_name'],
                        'last_name' => $userData['last_name'],
                        'email' => $userData['email'],
                        'is_active' => true,
                    ]);

                    $user->password = app()->security->generateRandomString(8);
                    $user->generateToken();

                    app()->db->beginTransaction();

                    if ($user->save()) {
                        // assign base RBAC role
                        auth()->assign(
                            auth()->getRole('user'),
                            $user->id
                        );

                        // create new auth client
                        $authClient = new AuthClient([
                            'user_id' => $user->id,
                            'source' => $client->getId(),
                            'source_id' => (string)$userData['id'],
                        ]);

                        if ($authClient->save()) {
                            app()->db->transaction->commit();

                            return $user->login();
                        } else {
                            // some error from auth client
                            session()->addFlash(
                                'errors', t('errors', 'auth/auth-client-error')
                            );

                            return $this->redirect(['/login']);
                        }
                    } else {
                        // some error from user
                        session()->addFlash(
                            'errors', t('errors', 'auth/auth-client-error')
                        );

                        return $this->redirect(['/login']);
                    }
                }
            }
        } else {
            // append new auth client data to the existing user
            if (!$authClient) {
                $authClient = new AuthClient([
                    'user_id' => user()->id,
                    'source' => $client->getId(),
                    'source_id' => (string)$userData['id'],
                ]);

                $authClient->save();
            }
        }

        return null;
    }
}