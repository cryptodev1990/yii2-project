<?php

declare(strict_types=1);

namespace app\mail\auth;

use app\core\interfaces\MailInterface;
use app\models\auth\User;
use yii\base\BaseObject;

class ResetPasswordMail extends BaseObject implements MailInterface
{
    /**
     * @var User
     */
    public User $user;

    function getData(): array
    {
        return [
            'link' => url(['/auth/set-password', 'token' => $this->user->token], true),
        ];
    }

    public function getFrom(): array
    {
        return [config('email.no-reply') => app()->name];
    }

    public function getTo(): string
    {
        return $this->user->email;
    }

    public function getSubject(): string
    {
        return t('mail', 'auth.reset.subject');
    }

    public function getView(): string
    {
        return 'auth/reset-password';
    }
}