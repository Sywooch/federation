<?
namespace app\models;

use yii\db\Query;

/**
 * Class User
 *
 * @package app\models
 */
class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    /**
     * @var int User id
     */
    public $id;

    /**
     * @var string User name
     */
    public $username;

    /**
     * @var string User email
     */
    public $email;

    /**
     * @var string User password
     */
    public $password;

    /**
     * @var string User authKey
     */
    public $authKey;

    /**
     * @var string User accessToken
     */
    public $accessToken;

    /**
     * @var string User full name
     */
    public $fio;

    /**
     * @var int User role
     */
    public $role;

    protected static $users;

    /**
     * Get all users. Set self::$users variable
     */
    protected static function getUsers()
    {
        $queryBuilder = new Query();
        $usersArr     = $queryBuilder
            ->select([
                'id',
                'username',
                'password',
                'authKey',
                'accessToken',
                'email',
                'fio',
                'role'
            ])
            ->from('users')
            ->all();

        if (! empty($usersArr)) {
            foreach ($usersArr as $u) {
                $users[$u['id']] = $u;
            }
        }

        self::$users = $users;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        self::getUsers();

        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        self::getUsers();
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string $username
     * @return static|null
     */

    public static function findByUsername($username)
    {
        self::getUsers();
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
