<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\forms\auth;

use app\core\interfaces\Sender;
use app\models\auth\User;
use yii\base\Exception;
use yii\base\Model;

class SignUpForm extends Model
{
    /**
     * User credentials
     */
    public $email;
    public $password;

    /**
     * Additional information about user
     */
    public $firstName;
    public $lastName;

    /**
     * Form validation rules
     * @return array
     */
    public function rules()
    {
        return [
            [['email', 'password', 'firstName', 'lastName'], 'required'],
            [['firstName', 'lastName'], 'string', 'min' => 2],

            ['email', 'unique', 'targetClass' => User::class, 'message' => t('errors', 'auth.user-already-exists')],
            ['email', 'email'],

            ['password', 'string', 'min' => 8, 'max' => 32],
        ];
    }

    /**
     * Attributes translation
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'email' => t('models', 'label.email'),
            'password' => t('models', 'label.password'),
            'firstName' => t('models', 'label.first_name'),
            'lastName' => t('models', 'label.last_name'),
        ];
    }

    /**
     * @return User|null
     * @throws Exception
     */
    public function handle()
    {
        // create a new user record
        $user = new User([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'is_active' => false,
        ]);

        $user->password = $this->password;
        $user->generateToken();

        if ($user->save()) {
            return $user;
        } else {
            return null;
        }
    }
}