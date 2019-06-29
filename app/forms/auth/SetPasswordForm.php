<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\forms\auth;

use app\models\auth\User;
use yii\base\Exception;
use yii\base\Model;

class SetPasswordForm extends Model
{
    /**
     * New password string value
     * @var string
     */
    public $password;

    /**
     * Form validation rules
     * @return array
     */
    public function rules()
    {
        return [
            ['password', 'required'],
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
            'password' => t('models', 'label.new-password'),
        ];
    }

    /**
     * @param User $user
     *
     * @return bool
     * @throws Exception
     */
    public function handle(User $user)
    {
        $user->password = $this->password;
        $user->generateToken();

        return $user->save();
    }
}