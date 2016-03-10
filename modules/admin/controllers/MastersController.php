<?
namespace app\modules\admin\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use app\modules\admin\models\AdminMasters;
use app\modules\admin\models\ExcelExportUsers;

/**
 * Class MastersController is responsible for handling masters in admin panel
 *
 * @package app\modules\admin\controllers
 */
class MastersController extends Controller
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
     * Index page of masters in admin panel
     *
     * @return string Html code
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Add new master
     *
     * @return string Html code
     */
    public function actionAdd()
    {
        $model    = new AdminMasters();
        $services = $model->getAllServices();

        return $this->render('add', [
            'model'    => $model,
            'services' => $services
        ]);
    }

    /**
     * Action for inserting a new master
     *
     * @return \yii\web\Response
     */
    public function actionAddSuccess()
    {
        $model = new AdminMasters();
        $post  = Yii::$app->request->post();

        $model->insertNewMaster($post);

        $this->redirect(Url::to(['/admin/masters/add']));
    }

    /**
     * Select masters for modify
     *
     * @return string Html code
     */
    public function actionAll()
    {
        $model   = new AdminMasters();
        $masters = $model->getAllMasters();

        return $this->render('all', [
            'model'   => $model,
            'masters' => $masters
        ]);
    }

    /**
     * Modify selected master
     *
     * @param int $id Master id
     * @return string Html code
     */
    public function actionReduction($id)
    {
        $model = new AdminMasters();

        $master         = $model->getMasterById($id);
        $services       = $model->getAllServices();
        $masterServices = $model->getMasterServices($id);
        $masterFotos    = $model->getMasterFotos($id);
        $masterComments = $model->getMasterComments($id);

        return $this->render('reduction', [
            'pathToRoot'     => Yii::$app->params['pathToRoot'],
            'model'          => $model,
            'master'         => $master,
            'services'       => $services,
            'masterServices' => $masterServices,
            'masterFotos'    => $masterFotos,
            'masterComments' => $masterComments
        ]);
    }

    /**
     * Apply changes for master after modification
     *
     * @return \yii\web\Response
     */
    public function actionReductionSuccess()
    {
        $model = new AdminMasters();

        $post = Yii::$app->request->post();

        $model->insertModifyData($post);

        $this->redirect(Url::to(['/admin/masters/reduction', 'id' => $post['id']]));
    }

    /**
     * Delete selected master
     *
     * @param int $id Master id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $model = new AdminMasters();

        $model->deleteMaster($id);

        $this->redirect(Url::to(['/admin/masters/all']));
    }

    /**
     * Select masters for sending message
     *
     * @return string Html code
     */
    public function actionSendMessage()
    {
        $model = new AdminMasters();

        $masters = $model->getAllMasters();

        return $this->render('allSendMessage', [
            'model'   => $model,
            'masters' => $masters
        ]);
    }

    /**
     * Send message for masters
     *
     * @return string Html code
     */
    public function actionSendMessageSuccess()
    {
        $model = new AdminMasters();

        $post = Yii::$app->request->post();

        $emails = $model->sendMessage($post);

        return $this->render('allSendMessageSuccess', [
            'model'   => $model,
            'emails'  => $emails,
            'message' => $post['messageForMasters']
        ]);
    }

    /**
     * Export masters to Excel file
     * Stay on the same page
     */
    public function actionExport()
    {
        $model = new ExcelExportUsers();

        $model->loadMastersToExcel();
    }
}
