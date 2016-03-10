<?
namespace app\modules\admin\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use app\modules\admin\models\AdminInformation;

/**
 * Class InformationController is responsible for handling articles in admin panel
 *
 * @package app\modules\admin\controllers
 */
class InformationController extends Controller
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
     * Index page of articles in admin panel
     *
     * @return string Html code
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Create new article
     *
     * @return string Html code
     */
    public function actionCreate()
    {
        $model = new AdminInformation();
        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            if ($post['AdminInformation']['mode'] == '1') {
                // preview mode
                $currentPost = $model->previewInformation($post);

                return $this->render('//information/informationFull', [
                    'currentPost' => $currentPost
                ]);

            } elseif ($post['AdminInformation']['mode'] == '2') {
                // insert mode
                $currentPost = $model->insertInformation($post);

                $currentPost['model'] = $model;

                $this->redirect(Url::to(['/information/index']));
            }
        } else {
            // create mode
            $model->mode = 1; // default value for radio element
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Select articles for deletion
     *
     * @return string Html code
     */
    public function actionDelete()
    {
        $model = new AdminInformation();

        $informations = $model->getAllInform();

        return $this->render('delete', [
            'informations' => $informations
        ]);
    }

    /**
     * Delete an article
     *
     * @return \yii\web\Response
     */
    public function actionDeleteSuccess()
    {
        $model = new AdminInformation();

        $post = Yii::$app->request->get();

        $model->deletePost($post);

        $this->redirect(Url::to(['/admin/information/delete']));
    }

    /**
     * Modify articles
     *
     * @return string Html code
     */
    public function actionReduction()
    {
        $model = new AdminInformation();

        $informations = $model->getAllInform();

        return $this->render('reduction', [
            'informations' => $informations
        ]);
    }

    /**
     * Modify selected article
     *
     * @param int $id Article id
     * @return string Html code|\yii\web\Response Redirect to index page of articles in admin panel
     */
    public function actionReductionCurrent($id)
    {
        $model = new AdminInformation();

        $currentInform = $model->getCurrentInform($id);

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            if ($post['AdminInformation']['mode'] == '1') {
                // preview mode
                $currentPost = $model->previewInformation($post);

                $currentPost = $model->prepareImgs($currentPost, $currentInform, $post);

                return $this->render('//information/informationFull', [
                    'mode'        => 'toTemp',
                    'currentPost' => $currentPost
                ]);

            } elseif ($post['AdminInformation']['mode'] == '2') {
                // insert mode
                $model->updateInformation($post, $currentInform, $id);

                $this->redirect(Url::to(['/information/index']));
            }
        } else {
            return $this->render('create', [
                'model'         => $model,
                'currentInform' => $currentInform
            ]);
        }
    }
}
