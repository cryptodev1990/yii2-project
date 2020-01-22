<?php

declare(strict_types=1);

namespace app\forms\auth;

use app\core\interfaces\Mailer;
use app\mail\auth\UserRegistrationMail;
use app\models\auth\User;
use yii\base\Exception;
use yii\base\Model;

class SignUpForm extends Model
{
    /**
     * User credentials
     */
    public $email;
    public $password;

    /**
     * Additional information about user
     */
    public $firstName;
    public $lastName;
    public $isActive = false;

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

    /**
     * SignUpForm constructor with Mailer object injection
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
     * @return User|null
     * @throws Exception
     * @throws \Exception
     */
    public function handle(): ?User
    {
        // create a new user record
        $user = new User([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'is_active' => $this->isActive,
        ]);

        $user->password = $this->password;
        $user->generateToken();

        if ($user->save()) {
            // create a welcome email
            $registrationEmail = new UserRegistrationMail([
                'email' => $this->email,
                'password' => $this->password,
                'token' => $user->token,
                'isActive' => $user->is_active,
            ]);

            $this->mailer->send($registrationEmail);

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
}