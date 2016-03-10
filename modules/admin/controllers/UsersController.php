<?
namespace app\modules\admin\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use app\modules\admin\models\AdminUsers;
use app\modules\admin\models\ExcelExportUsers;

/**
 * Class UsersController is responsible for handling users in admin panel
 *
 * @package app\modules\admin\controllers
 */
class UsersController extends Controller
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
     * Index page of users in admin panel
     *
     * @return string Html code
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Index page for deleting users
     *
     * @return string Html code
     */
    public function actionAll()
    {
        $model = new AdminUsers();
        $users = $model->getAllUsers();

        return $this->render('delete', [
            'users' => $users
        ]);
    }

    /**
     * Delete users
     *
     * @return \yii\web\Response Redirect to delete users index page
     */
    public function actionDelete()
    {
        $model = new AdminUsers();
        $post  = Yii::$app->request->get();

        $model->deleteUsers($post);

        return $this->redirect(Url::to(['/admin/users/all']));
    }

    /**
     * Export users to Excel file
     * Stay on the same page
     */
    public function actionExport()
    {
        $model = new ExcelExportUsers();

        $model->loadUsersToExcel();
    }
}
