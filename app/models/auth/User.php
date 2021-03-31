<?php

declare(strict_types=1);

namespace app\models\auth;

use manchenkov\yii\database\ActiveQuery;
use manchenkov\yii\database\ActiveRecord;
use manchenkov\yii\database\traits\SoftDelete;
use yii\base\Exception;
use yii\base\InvalidArgumentException;
use yii\behaviors\TimestampBehavior;
use yii\console\Response as ConsoleResponse;
use yii\web\IdentityInterface;
use yii\web\Response;

/**
 * Class User
 * @package App\Models
 *
 * @property int $id [int(11)]
 * @property string $email [varchar(255)]
 * @property string $password_hash [varchar(255)]
 * @property string $token [varchar(32)]
 * @property bool $is_active [bool]
 * @property string $first_name [varchar(255)]
 * @property string $last_name [varchar(255)]
 * @property int $created_at [int(11)]
 * @property int $updated_at [int(11)]
 * @property int $deleted_at [int(11)]
 * @property string $data [json]
 *
 * @property string $password
 * @property string $authKey
 * @property-read AuthClient[] $authClients
 */
final class User extends ActiveRecord implements IdentityInterface
{
    /**
     * Soft delete ActiveRecord trait
     */
    use SoftDelete;

    /**
     * Default URL after success login
     * @var array
     */
    private array $homeUrl = ['/me'];

    /**
     * @inheritdoc
     */
    public static function findIdentity($id): ?User
    {
        return self::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null): ?User
    {
        return self::findOne(['token' => $token]);
    }

    /**
     * Finds a user by 'email' value
     *
     * @param string $email
     *
     * @return User|null
     */
    public static function findIdentityByEmail(string $email): ?User
    {
        return self::findOne(['email' => $email]);
    }

    /**
     * Log in as user with passed ID
     *
     * @param int $id
     *
     * @return Response|ConsoleResponse
     */
    public static function loginById(int $id)
    {
        $user = self::findOne($id);

        if ($user) {
            return $user->login();
        }

        throw new InvalidArgumentException(t('errors', 'user.not-found'));
    }

    /**
     * Log current user in the system
     *
     * @param bool $currentSession
     *
     * @return ConsoleResponse|Response
     */
    public function login(bool $currentSession = false)
    {
        if (app()->user->isGuest || app()->user->id !== $this->id) {
            // log user in for current session time or 1 month (see params.php)
            app()->user->login(
                $this,
                $currentSession
                    ? 0
                    : config('user.loginSessionTime')
            );
        }

        // redirect to last/home page
        return response()->redirect(
            app()->user->returnUrl == app()->homeUrl
                ? url($this->homeUrl)
                : app()->user->returnUrl
        );
    }

    /**
     * Simple login as user with passed $id without redirect
     *
     * @param int $id
     *
     * @return bool
     */
    public static function loginAs(int $id): bool
    {
        $user = self::findOne($id);

        if ($user) {
            return app()->user->login($user);
        }

        throw new InvalidArgumentException(t('errors', 'user.not-found'));
    }

    /**
     * Model behaviors array
     * @return array
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * Model basic validation rules
     * @return array
     */
    public function rules(): array
    {
        return [
            [['email', 'password', 'first_name', 'last_name'], 'required'],
            [['password', 'token', 'first_name', 'last_name'], 'string'],
            ['email', 'email'],
            ['is_active', 'boolean'],
            [['created_at', 'updated_at', 'deleted_at'], 'integer'],
            ['data', 'safe'] // json field
        ];
    }

    /**
     * Model attributes labels' translation
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => '#',
            'email' => t('models', 'label.email'),
            'password' => t('models', 'label.password'),
            'token' => t('models', 'label.token'),
            'is_active' => t('models', 'label.is_active'),
            'first_name' => t('models', 'label.first_name'),
            'last_name' => t('models', 'label.last_name'),
            'created_at' => t('models', 'label.registered_at'),
            'updated_at' => t('models', 'label.updated_at'),
            'deleted_at' => t('models', 'label.deleted_at'),
            'data' => t('models', 'label.data'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getId(): int
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey(): string
    {
        return $this->token;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->token === $authKey;
    }

    /**
     * Returns a user password hash
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password_hash;
    }

    /**
     * Sets new value with encoding
     *
     * @param string $value
     *
     * @throws Exception
     */
    public function setPassword(string $value): void
    {
        $this->password_hash = app()->security->generatePasswordHash($value);
    }

    /**
     * Validates user password with a given value
     *
     * @param string $password
     *
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        return app()->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Updates user password
     *
     * @param string $newPassword
     *
     * @return bool
     * @throws Exception
     */
    public function updatePassword(string $newPassword): bool
    {
        $this->password = $newPassword;
        $this->generateToken();

        return $this->save();
    }

    /**
     * Generates a new token for current user
     * @throws Exception
     */
    public function generateToken(): void
    {
        $this->token = app()->security->generateRandomString();
    }

    /**
     * Activates user account
     * @return bool
     * @throws Exception
     */
    public function activate(): bool
    {
        $this->is_active = true;
        $this->generateToken();

        return $this->save();
    }

    /**
     * Returns all of the current user social auth clients
     * @return ActiveQuery
     */
    public function getAuthClients(): ActiveQuery
    {
        return $this->hasMany(AuthClient::class);
    }
}