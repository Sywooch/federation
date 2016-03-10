<?
namespace app\modules\admin\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use \app\models\Index;
use app\modules\admin\models\AdminMasters;
use app\modules\admin\models\Orders;

/**
 * Class OrdersController is responsible for handling orders in admin panel
 *
 * @package app\modules\admin\controllers
 */
class OrdersController extends Controller
{
    /**
     * @var int The number of orders for the one page before dataTables pagination
     */
    public $ordersOnPage = 100;

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
     * Index page of orders in admin panel
     *
     * @return string Html code
     */
    public function actionAll()
    {
        $model = new Orders();

        $pagination  = $model->getPagination($this->ordersOnPage);
        $orders      = $model->getAllOrders($this->ordersOnPage);
        $ordersToday = $model->getTodayOrders();

        return $this->render('orders', [
            'pathToRoot'   => Yii::$app->params['pathToRoot'],
            'pagination'   => $pagination,
            'orders'       => $orders,
            'ordersOnPage' => $this->ordersOnPage,
            'ordersToday'  => $ordersToday

        ]);
    }

    /**
     * Index page for order modification
     *
     * @param int $id Order id
     * @return string Html code
     */
    public function actionModify($id)
    {
        $model        = new Orders();
        $modelMasters = new AdminMasters();
        $modelIndex   = new Index();

        $order    = $model->getOrderById($id);
        $masters  = $modelMasters->getAllMasters();
        $statuses = $model->getStatuses();

        return $this->renderAjax('orders_modify_content', [
            'model'         => $model,
            'masters'       => $masters,
            'order'         => $order,
            'statuses'      => $statuses,
            'servicesLevel' => $modelIndex->getServicesLevel()
        ]);
    }

    /**
     * Modify order
     *
     * @return \yii\web\Response Redirect to previous page
     */
    public function actionModifyAccept()
    {
        $model = new Orders();
        $post  = Yii::$app->request->get();

        $model->insertModifyData($post);

        return $this->redirect(Url::previous());
    }

    /**
     * Delete order
     *
     * @param int $id Id for selected order
     * @return \yii\web\Response Redirect to previous page
     */
    public function actionModifyOrderDelete($id)
    {
        $model = new Orders();

        $model->deleteOrderById($id);

        return $this->redirect(Url::previous());
    }
}
