<?php

declare(strict_types=1);

namespace app\mail\auth;

use app\models\auth\User;
use manchenkov\yii\mail\Mailable;
use yii\base\BaseObject;

class ResetPasswordMail extends BaseObject implements Mailable
{
    /**
     * @var User
     */
    public $user;

    /**
     * Returns a prepared data to compose mail view (use in `send()` method)
     * @return array
     */
    function data(): array
    {
        return [
            'link' => url(['/auth/set-password', 'token' => $this->user->token], true),
        ];
    }

    public function from(): array
    {
        return [config('email.no-reply') => app()->name];
    }

    public function to(): string
    {
        return $this->user->email;
    }

    public function subject(): string
    {
        return t('mail', 'auth.reset.subject');
    }

    public function view(): string
    {
        return 'auth/reset-password';
    }
}