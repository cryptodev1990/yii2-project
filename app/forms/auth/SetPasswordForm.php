<?php

declare(strict_types=1);

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
    public function rules(): array
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
    public function attributeLabels(): array
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
    public function handle(User $user): bool
    {
        return $user->updatePassword($this->password);
    }
}