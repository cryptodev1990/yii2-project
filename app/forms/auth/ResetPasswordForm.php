<?php

declare(strict_types=1);

namespace app\forms\auth;

use app\core\interfaces\Mailer;
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
     * @var Mailer
     */
    protected $mailer;

    /**
     * Form validation rules
     * @return array
     */
    public function rules(): array
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
    public function attributeLabels(): array
    {
        return [
            'email' => t('models', 'label.email'),
        ];
    }

    /**
     * ResetPasswordForm constructor with Mailer object injection
     *
     * @param Mailer $mailer
     * @param array $config
     */
    public function __construct(Mailer $mailer, $config = [])
    {
        parent::__construct($config);

        $this->mailer = $mailer;
    }

    /**
     * Send reset password email
     * @return bool
     */
    public function handle(): bool
    {
        $user = User::findIdentityByEmail($this->email);

        if ($user) {
            $resetPasswordEmail = new ResetPasswordMail(['user' => $user]);

            return $this->mailer->send($resetPasswordEmail);
        } else {
            return false;
        }
    }
}