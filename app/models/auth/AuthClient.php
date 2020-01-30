<?php

declare(strict_types=1);

namespace app\models\auth;

use app\core\services\auth\UserDetailsParser;
use app\forms\auth\SignUpForm;
use Exception;
use manchenkov\yii\database\ActiveQuery;
use manchenkov\yii\database\ActiveRecord;
use yii\authclient\ClientInterface;
use yii\web\Response;

/**
 * Class AuthClient to store social auth clients data
 * @package App\Models\Auth
 *
 * @property int $id [int(11)]
 * @property int $user_id [int(11)]
 * @property string $source [varchar(255)]
 * @property string $source_id [varchar(255)]
 *
 * @property-read User $user
 */
class AuthClient extends ActiveRecord
{
    /**
     * Data validation rules
     * @return array
     */
    public function rules(): array
    {
        return [
            ['user_id', 'integer'],
            [['source', 'source_id'], 'string'],
        ];
    }

    /**
     * Returns user of current client
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->belongsTo(User::class);
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
    public static function onAuthSuccess(ClientInterface $client): ?Response
    {
        // get information about user from external service
        $userDetailsParser = new UserDetailsParser($client);
        $userData = $userDetailsParser->parseUserDetails();

        // search existing auth client item
        $authClient = self::findOne(
            [
                'source' => $client->getId(),
                'source_id' => $userData->getId(),
            ]
        );

        // if guest - try to login/register
        if (user()->isGuest) {
            // login if exists
            if ($authClient) {
                return $authClient->user->login();
            }

            // find existing user
            $user = User::findIdentityByEmail($userData->getEmail());

            if (!$user) {
                $signUpForm = invoke(
                    SignUpForm::class,
                    [
                        'email' => $userData->getEmail(),
                        'firstName' => $userData->getFirstName(),
                        'lastName' => $userData->getLastName(),
                        'password' => app()->security->generateRandomString(8),
                        'isActive' => true,
                    ]
                );

                if (!$user = $signUpForm->handle()) {
                    // some error from user
                    session()->addFlash(
                        'errors',
                        t('errors', 'auth.auth-client-error')
                    );

                    return response()->redirect(['sign-up']);
                }
            }

            // create new auth client
            $authClient = new self(
                [
                    'user_id' => $user->id,
                    'source' => $client->getId(),
                    'source_id' => (string) $userData->getId(),
                ]
            );

            $authClient->save();

            return $user->login();
        } else {
            // append new auth client data to the existing user
            if (!$authClient) {
                $authClient = new AuthClient(
                    [
                        'user_id' => user()->id,
                        'source' => $client->getId(),
                        'source_id' => (string) $userData->getId(),
                    ]
                );

                $authClient->save();
            }
        }

        return user()->loginRequired();
    }

}