<?
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\helpers\GoBackHelper;
use app\models\Masters;
use app\models\Comment;

/**
 * MastersController class is responsible for handling section with master's info
 *
 * @package app\controllers
 */
class MastersController extends Controller
{
    /**
     * @var int The number of comments on the one page
     */
    public $commentsOnPage = 5;

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
     * Remember the url
     *
     * @param \yii\base\Action $action
     * @param string           $result
     * @return string Html code
     */
    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        if (GoBackHelper::checkRememberUrl()) {
            Url::remember();
        }

        return $result;
    }

    /**
     * Page with all masters
     *
     * @return string Html code
     */
    public function actionAll()
    {
        $model = new Masters();

        $comments   = $model->getCommentsAll();
        $services   = $model->getServices();
        $foto       = $model->getFoto();
        $pagination = $model->getPagination(Yii::$app->params['mastersOnPage']);
        $masters    = $model->getMastersPagination();

        return $this->render('index', [
            'model'         => $model,
            'masters'       => $masters,
            'comments'      => $comments,
            'services'      => $services,
            'foto'          => $foto,
            'pagination'    => $pagination,
            'mastersOnPage' => Yii::$app->params['mastersOnPage'],
            'pathToRoot'    => Yii::$app->params->pathToRoot
        ]);
    }

    /**
     * Show information about the selected master
     *
     * @param int $id Id for the selected master
     * @return string Html code
     */
    public function actionPerson($id)
    {
        $model = new Masters();

        $commentsAll = $model->getCommentsAll($id);
        $pagination  = $model->getPaginationComments($this->commentsOnPage);
        $comments    = $model->getComments($id);
        $master      = $model->getMasterById($id);
        $services    = $model->getServices($id);
        $foto        = $model->getFoto($id);

        return $this->render('person', [
            'model'          => $model,
            'master'         => $master,
            'commentsAll'    => $commentsAll,
            'services'       => $services,
            'foto'           => $foto,
            'id'             => $id,
            'comments'       => $comments,
            'pagination'     => $pagination,
            'commentsOnPage' => $this->commentsOnPage
        ]);
    }

    /**
     * Send a comment about the master
     *
     * @param int    $id   Master's id
     * @param string $name Master's name
     * @return string Html code
     */
    public function actionComment($id, $name)
    {
        $model = new Comment();

        if ($model->load(Yii::$app->request->post())) {
            $post    = Yii::$app->request->post();
            $userId  = Yii::$app->user->identity->id;
            $userFio = Yii::$app->user->identity->fio;

            $model->insertCommentAboutMaster($post, $id, $userId);
            $model->updateRating($id);
            $model->sendEmailAboutMaster($post, $id, $userFio);

            return $this->render('commentSuccess', [
                'model' => $model,
                'id'    => $id,
                'name'  => $name
            ]);
        } else {
            $model->side = 1; // set the selected radio element
            return $this->render('comment', [
                'model' => $model,
                'id'    => $id,
                'name'  => $name
            ]);
        }
    }

    /**
     * Send a request to join the federation
     *
     * @return string Html code
     */
    public function actionEnter()
    {
        $model = new Masters();
        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            $model->sendEnter($post);
            $model->sendEnterForMaster($post);

            return $this->render('enterSuccess');
        } else {
            return $this->render('enter', [
                'model' => $model
            ]);
        }
    }
}
