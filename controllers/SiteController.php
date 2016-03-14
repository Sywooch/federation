<?
namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\helpers\Url;
use yii\helpers\GoBackHelper;
use app\models\Index;
use app\models\Comment;
use app\models\Hour;

/**
 * Class SiteController is responsible for handling index page,
 * send order, contact, send comment, about us, 'Man on hour' and back call pages
 *
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * Set captcha params
     *
     * @return array
     */
    public function actions()
    {
        return [
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
     * Index page on the site
     *
     * @return string Html code
     */
    public function actionIndex()
    {
        $model = new Index();

        return $this->render('index', [
            'model'         => $model,
            'servicesLevel' => $model->getServicesLevel(),
        ]);
    }

    /**
     * The page for adding order
     *
     * @return string Html code
     */
    public function actionAdd()
    {
        $model = new Index();
        $post  = Yii::$app->request->post();

        return $this->render('addOrder', [
            'servicesLevel' => $model->getServicesLevel(),
            'model'         => $model,
            'post'          => $post,
        ]);
    }

    /**
     * Send an order
     *
     * @return string Html code
     */
    public function actionAddSuccess()
    {
        $model = new Index();
        $post  = Yii::$app->request->post();

        if (! $model->validate()) {
            $nameFiles = $model->getFiles();

            $model->insertData($post, $nameFiles);
            $model->sendEmail($post, $nameFiles);
            $model->sendClientEmail($post);

            return $this->render('addSuccess');
        } else {
            return $this->render('addOrder', [
                'servicesLevel' => $model->getServicesLevel(),
                'model'         => $model,
                'post'          => $post,
            ]);
        }
    }

    /**
     * Send a comment
     *
     * @return string Html code
     */
    public function actionSendComment()
    {
        $model = new Comment();

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            $model->insertComment($post);
            $model->sendEmail($post);

            return $this->render('commentSuccess', [
                'model'       => $model,
                'whatWasSend' => 'Отзыв'
            ]);

        } else {
            return $this->render('sendComment', [
                'model' => $model
            ]);
        }
    }

    /**
     * The page about federation
     *
     * @return string Html code
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * The page with contacts, where user can send a message for federation
     *
     * @return string Html code
     */
    public function actionContact()
    {
        $model = new Comment();

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            $model->insertComment($post);
            $model->sendEmail($post);

            return $this->render('commentSuccess', [
                'model'       => $model,
                'whatWasSend' => 'Вопрос'
            ]);
        } else {
            return $this->render('contact', [
                'model' => $model
            ]);
        }
    }

    /**
     * 'Man on hour' page
     *
     * @return string Html code
     */
    public function actionHour()
    {
        $model = new Hour();

        $pagination = $model->getPagination(Yii::$app->params['hourOnPage']);
        $hours      = $model->getAllHours();

        return $this->render('hour', [
            'model'      => $model,
            'pagination' => $pagination,
            'hours'      => $hours
        ]);
    }

    /**
     * Search in 'Man on hour' page
     *
     * @return string Html code
     */
    public function actionHourSearch()
    {
        $model = new Hour();

        $post = Yii::$app->request->post();
        $str  = $post['Hour']['search'];

        $model->search = $str;

        $hours = $model->search($str);

        return $this->render('hour', [
            'model' => $model,
            'hours' => $hours,
            'str'   => $str
        ]);
    }

    /**
     * Callback window
     *
     * @return string Html code
     */
    public function actionBackCall()
    {
        return $this->renderAjax('backCall');
    }

    /**
     * Send time for callback
     *
     * @return string Html code
     */
    public function actionBackCallSend()
    {
        $model = new Comment();

        $post = Yii::$app->request->get();

        $model->sendEmailBackCall($post);

        return $this->render('backCallSuccess', [
            'model' => $model
        ]);
    }

    /**
     * Action on error
     *
     * @return string
     */
    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }
}
