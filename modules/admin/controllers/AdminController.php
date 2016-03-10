<?
namespace app\modules\admin\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

/**
 * Class AdminController is responsible for handling index page in admin panel
 *
 * @package app\modules\admin\controllers
 */
class AdminController extends Controller
{
    /**
     * Set the post method to the logout action
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Set the error handler
     *
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
        ];
    }

    /**
     * Check the status of admin
     *
     * @param \yii\base\Action $action
     * @return bool
     * @throws NotFoundHttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (Yii::$app->user->identity->role <= 1) {
            throw new NotFoundHttpException;
        }

        if (! strstr(Url::current(), '/modify')) {
            Url::remember();
        }

        return parent::beforeAction($action);
    }

    /**
     * Index page in admin panel
     *
     * @return string Html code
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
