<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\models\auth;

use app\extensions\database\ActiveRecord;
use yii\authclient\ClientInterface;

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
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
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
}