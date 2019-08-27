<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\models\auth;

use manchenkov\yii\database\ActiveRecord;
use app\forms\auth\SignUpForm;
use Exception;
use Yii;
use yii\authclient\ClientInterface;
use yii\db\ActiveQuery;
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
    public function rules()
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
    public function getUser()
    {
        return $this->belongsTo(User::class, ['id' => 'user_id']);
    }

    /**
     * Returns structured information about the user from external services
     *
     * @param ClientInterface $client
     *
     * @return array
     */
    public static function parseUserDetails(ClientInterface $client)
    {
        // required values
        $details = [
            'id' => '',
            'first_name' => '',
            'last_name' => '',
            'email' => '',
        ];

        // get data from response
        $data = $client->getUserAttributes();
        // get external service name
        $service = $client->getName();

        // set user's data: external id, email
        $details['id'] = $data['id'];
        $details['email'] = $data['email'];

        // see docs for details about response key names
        switch ($service) {
            case 'google':
                $details['first_name'] = $data['given_name'];
                $details['last_name'] = $data['family_name'];
                break;
            case 'facebook':
            case 'github':
                list($details['first_name'], $details['last_name']) = explode(' ', $data['name']);
                break;
            case 'vkontakte':
                $details['first_name'] = $data['first_name'];
                $details['last_name'] = $data['last_name'];
                break;
        }

        return $details;
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
    public static function onAuthSuccess(ClientInterface $client)
    {
        // get information about user from external service
        $userData = self::parseUserDetails($client);

        // search existing auth client item
        $authClient = self::findOne([
            'source' => $client->getId(),
            'source_id' => $userData['id'],
        ]);

        // if guest - try to login/register
        if (user()->isGuest) {
            // login if exists
            if ($authClient) {
                return $authClient->user->login();
            }

            // find existing user
            $user = User::findIdentityByEmail($userData['email']);

            if (!$user) {
                $signUpForm = Yii::createObject([
                    'class' => SignUpForm::class,
                    'email' => $userData['email'],
                    'firstName' => $userData['first_name'],
                    'lastName' => $userData['last_name'],
                    'password' => app()->security->generateRandomString(8),
                    'isActive' => true,
                ]);

                if (!$user = $signUpForm->handle()) {
                    // some error from user
                    session()->addFlash(
                        'errors', t('errors', 'auth.auth-client-error')
                    );

                    return response()->redirect(['sign-up']);
                }
            }

            // create new auth client
            $authClient = new self([
                'user_id' => $user->id,
                'source' => $client->getId(),
                'source_id' => (string)$userData['id'],
            ]);

            $authClient->save();

            return $user->login();
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

        return user()->loginRequired();
    }

}