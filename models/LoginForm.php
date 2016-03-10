<?
namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    /**
     * @var string Input value from 'username' field. User login
     */
    public $username;

    /**
     * @var string Input value from 'password' field. User password
     */
    public $password;

    /**
     * @var string|null Input value from rememberMe checkbox
     */
    public $rememberMe = true;

    /**
     * @var User|null
     */
    private $_user = false;

    /**
     * Rules for form validation
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'password'],
             'required',
             'message' => 'Поле должно быть заполненным'
            ],
            ['rememberMe',
             'boolean'
            ],
            ['password',
             'validatePassword',
             'message' => 'Пароль не верный!'
            ],
        ];
    }

    /**
     * Validates the password
     * This method serves as the inline validation for password
     *
     * @param string $attribute The attribute currently being validated
     */
    public function validatePassword($attribute)
    {
        if (! $this->hasErrors()) {
            $user = $this->getUser();
            if (! $user
                || ! Yii::$app->getSecurity()
                    ->validatePassword($this->password, $user->password)
            ) {
                $this->addError($attribute, 'Неверный логин или пароль. Проверьте, пожалуйста');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
