<?
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Registration;

/**
 * Class UserController is responsible for handling login, logout and registration pages
 *
 * @package app\controllers
 */
class UserController extends Controller
{
    /**
     * Set the post method to the logout action
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Set the error handler and captcha params
     *
     * @return array
     */
    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction'
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength'       => 3,
                'maxLength'       => 4,
                'offset'          => 5,
                'foreColor'       => 0x2268b0
            ],
        ];
    }

    /**
     * Login page
     *
     * @return string Html code|\yii\web\Response Redirect to previous page
     */
    public function actionLogin()
    {
        if (! Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            $this->redirect(Url::previous());
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action
     *
     * @return \yii\web\Response Redirect to home page
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * User registration
     *
     * @return string Html code|\yii\web\Response
     */
    public function actionRegistration()
    {
        $model = new Registration();

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            if ($model->checkUsername($post['Registration']['username'])) {
                $model->insertNewUser($post);
                $model->loginAfterRegistration($post['Registration']['username']);

                return $this->goBack();
            } else {
                return $this->render('registration', [
                    'model'    => $model,
                    'errorMsg' => 'Такой логин уже существует. Введите другой'
                ]);
            }
        } else {
            return $this->render('registration', [
                'model' => $model,
            ]);
        }
    }
}
