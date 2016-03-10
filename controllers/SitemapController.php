<?
namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use app\models\Sitemap;

/**
 * Class SitemapController is responsible for handling /sitemap.xml request
 *
 * @package app\controllers
 */
class SitemapController extends Controller
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
     * Generate sitemap.xml file
     *
     * @return string Html code
     */
    public function actionIndex()
    {
        $model = new Sitemap();

        $urlsAll = $model->getSitemap();

        // set the xml content-type for response
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;

        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');

        // use the renderPartial for skipping the layouts
        return $this->renderPartial('index', [
            'urlsAll' => $urlsAll,
        ]);
    }
}
