<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\forms\auth;

use app\core\interfaces\Sender;
use app\mail\auth\ResetPasswordMail;
use app\models\auth\User;
use yii\base\Model;

class ResetPasswordForm extends Model
{
    /**
     * User e-mail
     * @var string
     */
    public $email;

    /**
     * Form validation rules
     * @return array
     */
    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist', 'targetClass' => User::class, 'message' => t('errors', 'password.user-not-found')],
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
        ];
    }

    public function handle(Sender $mailer)
    {
        $user = User::findIdentityByEmail($this->email);

        if ($user) {
            $resetPasswordEmail = new ResetPasswordMail(['user' => $user]);

            return $mailer->send($resetPasswordEmail);
        } else {
            return false;
        }
    }
}