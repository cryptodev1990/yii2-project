<?php

declare(strict_types=1);

namespace app\forms\auth;

use app\core\interfaces\MailerInterface;
use app\mail\auth\UserRegistrationMail;
use app\models\auth\User;
use manchenkov\yii\data\Form;

final class SignUpForm extends Form
{
    public ?string $email = null;
    public ?string $password = null;

    public ?string $firstName = null;
    public ?string $lastName = null;
    public bool $isActive = false;

    protected MailerInterface $mailer;

    /**
     * SignUpForm constructor with Mailer object injection
     *
     * @param MailerInterface $mailer
     * @param array $config
     */
    public function __construct(MailerInterface $mailer, $config = [])
    {
        parent::__construct($config);

        $this->mailer = $mailer;
    }

    /**
     * Form validation rules
     * @return array
     */
    public function rules(): array
    {
        return [
            [['email', 'password', 'firstName', 'lastName'], 'required'],
            [['firstName', 'lastName'], 'string', 'min' => 2],

            ['email', 'unique', 'targetClass' => User::class, 'message' => t('errors', 'auth.user-already-exists')],
            ['email', 'email'],

            ['password', 'string', 'min' => 8, 'max' => 32],
            ['isActive', 'boolean'],
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
            'firstName' => t('models', 'label.first_name'),
            'lastName' => t('models', 'label.last_name'),
        ];
    }

    public function handle(): ?User
    {
        $user = $this->createUser();

        if ($user->save()) {
            $this->sendWelcomeEmail($user);

            // assign base RBAC role
            auth()->assign(
                auth()->getRole('user'),
                $user->id
            );

            return $user;
        } else {
            return null;
        }
    }

    private function createUser(): User
    {
        $user = new User(
            [
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'email' => $this->email,
                'is_active' => $this->isActive,
            ]
        );

        $user->password = $this->password;
        $user->generateToken();

        return $user;
    }

    private function sendWelcomeEmail(User $user): void
    {
        $registrationEmail = new UserRegistrationMail(
            [
                'email' => $this->email,
                'password' => $this->password,
                'token' => $user->token,
                'isActive' => $user->is_active,
            ]
        );

        $this->mailer->send($registrationEmail);
    }
}