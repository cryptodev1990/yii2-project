<?php

declare(strict_types=1);

namespace app\forms\auth;

use app\models\auth\User;
use manchenkov\yii\data\Form;
use manchenkov\yii\recaptcha\ReCaptchaValidator;

final class LoginForm extends Form
{
    /**
     * User email value
     * @var string|null
     */
    public ?string $email = null;

    /**
     * User password
     * @var string|null
     */
    public ?string $password = null;

    /**
     * Google reCAPTCHA v3
     * @var string|null
     */
    public ?string $captcha = null;

    /**
     * Form validation rules
     * @return array
     */
    public function rules(): array
    {
        return [
            [['email', 'password'], 'required'],
            [['email', 'password'], 'string'],
            ['captcha', ReCaptchaValidator::class, 'action' => 'login'],
        ];
    }

    /**
     * Attributes translation
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'email' => t('models', 'label.email'),
            'password' => t('models', 'label.password'),
        ];
    }

    /**
     * Finds and validates user by credentials
     * @return User|null
     */
    public function handle(): ?User
    {
        $user = User::findIdentityByEmail($this->email);

        if ($user) {
            if ($user->is_active) {
                if ($user->validatePassword($this->password)) {
                    return $user;
                }
            } else {
                $this->addError('email', t('errors', 'auth.user-is-not-active'));
            }
        }

        if (!$this->hasErrors()) {
            $this->addError('email', t('errors', 'auth.invalid-credentials'));
        }

        return null;
    }
}