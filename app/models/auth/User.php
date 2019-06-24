<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\models\auth;

use app\extensions\database\ActiveRecord;
use app\extensions\database\traits\SoftDelete;
use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
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
 * @property-read AuthClient[] $authClients
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * Soft delete ActiveRecord trait
     */
    use SoftDelete;

    /**
     * Default URL after success login
     * @var array
     */
    private $homeUrl = ['/me'];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_user';
    }

    /**
     * Model behaviors array
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * Model basic validation rules
     * @return array
     */
    public function rules()
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
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'email' => t('models', 'label/email'),
            'password' => t('models', 'label/password'),
            'token' => t('models', 'label/token'),
            'is_active' => t('models', 'label/is_active'),
            'first_name' => t('models', 'label/first_name'),
            'last_name' => t('models', 'label/last_name'),
            'created_at' => t('models', 'label/registered_at'),
            'updated_at' => t('models', 'label/updated_at'),
            'deleted_at' => t('models', 'label/deleted_at'),
            'data' => t('models', 'label/data'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
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
    public static function findIdentityByEmail(string $email)
    {
        return self::findOne(['email' => $email]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->token;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->token == $authKey;
    }

    /**
     * Returns a user password hash
     * @return string
     */
    public function getPassword()
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
    public function setPassword(string $value)
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
    public function validatePassword(string $password)
    {
        return app()->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates a new token for current user
     * @throws Exception
     */
    public function generateToken()
    {
        $this->token = app()->security->generateRandomString();
    }

    /**
     * @param string $newPassword
     *
     * @return bool
     * @throws Exception
     */
    public function updatePassword(string $newPassword)
    {
        $this->password = $newPassword;
        $this->generateToken();

        return $this->save();
    }

    /**
     * Log current user in the system
     *
     * @param bool $currentSession
     *
     * @return \yii\console\Response|Response
     */
    public function login(bool $currentSession = false)
    {
        // log user in for current session time or 1 month (see params.php)
        user()->login(
            $this,
            $currentSession
                ? 0
                : config('user.loginSessionTime')
        );

        // redirect to last/home page
        return response()->redirect(
            user()->returnUrl == app()->homeUrl
                ? url($this->homeUrl)
                : user()->returnUrl
        );
    }

    /**
     * Returns all of the current user social auth clients
     * @return ActiveQuery
     */
    public function getAuthClients()
    {
        return $this->hasMany(AuthClient::class, ['user_id' => 'id']);
    }
}