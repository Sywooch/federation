<?
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Query;

/**
 * Class Registration provides logic for user registration
 *
 * @package app\models
 */
class Registration extends Model
{
    /**
     * @var string Input value from 'username' field. Client name
     */
    public $username;

    /**
     * @var string Input value from 'email' field. Client email
     */
    public $email;

    /**
     * @var string Input value from 'fio' field. Client full name
     */
    public $fio;

    /**
     * @var string Input value from 'password' field. Client password
     */
    public $password;

    /**
     * @var string Input value from 'confirm' field. Confirm password
     */
    public $confirm;

    /**
     * @var string Input value from captcha field
     */
    public $captcha;

    /**
     * @var string|null Input value from rememberMe checkbox
     */
    public $rememberMe = true;

    /**
     * Rules for form validation
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'confirm', 'captcha'],
             'required',
             'message' => 'Поле должно быть заполненным'
            ],
            ['username',
             'string',
             'min'      => 4, 'max' => 30,
             'tooShort' => 'Введите минимум 4 символа',
             'tooLong'  => 'Максимальная длина 30 символов, у Вас больше'
            ],
            ['password',
             'string',
             'min'      => 5, 'max' => 30,
             'tooShort' => 'Введите минимум 5 символов',
             'tooLong'  => 'Максимальная длина 30 символов, у Вас больше'
            ],
            ['email',
             'email',
             'message' => 'Введите реальный Email, например client@mail.ru'
            ],
            ['confirm', 'compare',
             'compareAttribute' => 'password',
             'message'          => 'Пароли не совпадают. Проверьте правильность ввода Пароля и Повторения пароля'
            ],
            ['captcha',
             'captcha',
             'message' =>
                 'Символы введены не верно, проверьте пожалуйста, или обновите картинку и попробуйте еще раз'
            ],
            [['fio', 'email'],
             'string',
             'max'     => 50,
             'tooLong' => 'Максимальная длина 50 символов, у Вас больше'
            ]
        ];
    }

    /**
     * Insert new user
     *
     * @param array $post Input values from user
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function insertNewUser($post)
    {
        $hash = Yii::$app->getSecurity()
            ->generatePasswordHash($post['Registration']['password']);

        $db = Yii::$app->db;

        $params = [
            ':username' => $post['Registration']['username'],
            ':password' => $hash,
            ':email'    => $post['Registration']['email'],
            ':fio'      => $post['Registration']['fio']
        ];

        $db->createCommand(
            "INSERT INTO users (
                username,
                email,
                password,
                fio
            )
            VALUES (
                :username,
                :email,
                :password,
                :fio
            )"
        )
            ->bindValues($params)
            ->execute();
    }

    /**
     * Check username field for unique
     *
     * @param string $username Input login
     * @return bool
     */
    public function checkUsername($username)
    {
        $users = $this->getAllUsers();
        if (! empty($users)) {
            foreach ($users as $u) {
                if ($u['username'] == $username) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Get all users
     *
     * @return array
     */
    protected function getAllUsers()
    {
        $queryBuilder = new Query();

        $users = $usersArr = $queryBuilder
            ->select(['username'])
            ->from('users')
            ->all();

        return $users;
    }

    /**
     * Login after registration
     *
     * @param string $username Input login
     */
    public function loginAfterRegistration($username)
    {
        Yii::$app->user->login(User::findByUsername($username));
    }
}
