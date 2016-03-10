<?
namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\helpers\Url;
use yii\helpers\GoBackHelper;
use app\models\Information;

/**
 * InformationController class is responsible for handling pages with articles
 *
 * @package app\controllers
 */
class InformationController extends Controller
{
    /**
     * Set the post method to logout action
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
     * Set the error handler and captcha params
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
     * Remember the url
     *
     * @param \yii\base\Action $action
     * @param string           $result
     * @return string Html code
     */
    public function afterAction($action, $result)
    {
        if (GoBackHelper::checkRememberUrl()) {
            Url::remember();
        }

        return $result;
    }

    /**
     * Index page in the information section with all articles
     *
     * @return string Html code
     */
    public function actionIndex()
    {
        $model = new Information();

        $pagination = $model->getPagination(Yii::$app->params['infoOnPage']);
        $allPosts   = $model->getAllPosts();

        return $this->render('information', [
            'allPosts'   => $allPosts,
            'pagination' => $pagination
        ]);
    }

    /**
     * Show the full article text
     *
     * @param int $id Id of the selected article
     * @return string Html code
     */
    public function actionInformationFull($id)
    {
        $model = new Information();

        $currentPost = $model->getCurrentPost($id);

        return $this->render('informationFull', [
            'mode'        => null,
            'currentPost' => $currentPost
        ]);
    }
}
