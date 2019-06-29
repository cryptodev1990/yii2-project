<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\mail\auth;

use app\extensions\mail\Mailable;
use yii\base\BaseObject;

class UserRegistrationMail extends BaseObject implements Mailable
{
    public $email;
    public $password;
    public $token;

    /**
     * Returns a prepared data to compose mail view (use in `send()` method)
     * @return array
     */
    public function data(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
            'link' => url(['/auth/activate-user', 'token' => $this->token], true),
        ];
    }

    public function from(): array
    {
        return [config('email.no-reply') => app()->name];
    }

    public function to(): string
    {
        return $this->email;
    }

    public function subject(): string
    {
        return t('mail', 'auth.subject');
    }

    public function view(): string
    {
        return 'auth/user-registration';
    }
}