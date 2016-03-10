<?
namespace app\modules\admin\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use app\modules\admin\models\AdminHour;

/**
 * Class HourController is responsible for handling ads in admin panel
 *
 * @package app\modules\admin\controllers
 */
class HourController extends Controller
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
     * Index page for ads in admin panel
     *
     * @return string Html code
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Add a new advert
     *
     * @return string Html code
     */
    public function actionAdd()
    {
        $model = new AdminHour();

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            if ($model->checkForCopy($post)) {

                $model->insertHour($post);

                $this->redirect(Url::to(['/site/hour']));
            } else {
                return $this->render('add', [
                    'model'    => $model,
                    'errorMsg' => 'Такое объявление уже существует!'
                ]);
            }
        }

        return $this->render('add', [
            'model' => $model
        ]);
    }

    /**
     * Select ads for deletion
     *
     * @return string Html code
     */
    public function actionDelete()
    {
        $model = new AdminHour();
        $hours = $model->getAllHours();

        return $this->render('delete', [
            'model' => $model,
            'hours' => $hours
        ]);
    }

    /**
     * Delete an advert
     *
     * @return \yii\web\Response
     */
    public function actionDeleteSuccess()
    {
        $model = new AdminHour();

        $post = Yii::$app->request->post();

        $model->deleteHour($post);

        $this->redirect(Url::to(['/admin/hour/delete']));
    }

    /**
     * Modify adverts
     *
     * @return string Html code
     */
    public function actionReduction()
    {
        $model = new AdminHour();
        $hours = $model->getAllHours();

        return $this->render('reduction', [
            'model' => $model,
            'hours' => $hours
        ]);
    }

    /**
     * Modify selected advert
     *
     * @param int $id Ad id
     * @return string
     */
    public function actionReductionCurrent($id)
    {
        $model = new AdminHour();

        $model->getCurrentHour($id);

        return $this->render('reductionCurrent', [
            'model' => $model,
            'id'    => $id
        ]);
    }

    /**
     * Apply changes for ad
     *
     * @param int $id Ad id
     * @return \yii\web\Response Redirect to index page of ads in admin panel
     */
    public function actionUpdate($id)
    {
        $model = new AdminHour();
        $post  = Yii::$app->request->post();

        $model->updateHour($post, $id);
        $this->redirect(Url::to(['/site/hour']));
    }
}
