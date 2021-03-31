<?php

declare(strict_types=1);

namespace app\forms\auth;

use app\models\auth\User;
use manchenkov\yii\data\Form;
use yii\base\Exception;

final class SetPasswordForm extends Form
{
    /**
     * New password string value
     * @var string|null
     */
    public ?string $password = null;

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