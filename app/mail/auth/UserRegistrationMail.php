<?php

declare(strict_types=1);

namespace app\mail\auth;

use app\core\interfaces\MailInterface;
use yii\base\BaseObject;

class UserRegistrationMail extends BaseObject implements MailInterface
{
    public string $email;
    public string $password;
    public string $token;
    public bool $isActive;

    public function getData(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
            'isActive' => $this->isActive,
            'link' => url(['/auth/activate-user', 'token' => $this->token], true),
        ];
    }

    public function getFrom(): array
    {
        return [config('email.no-reply') => app()->name];
    }

    public function getTo(): string
    {
        return $this->email;
    }

    public function getSubject(): string
    {
        return t('mail', 'auth.subject');
    }

    public function getView(): string
    {
        return 'auth/user-registration';
    }
}