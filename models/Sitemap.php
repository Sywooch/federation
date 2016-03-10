<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\helpers\TranslitHelper;

/**
 * Class Sitemap provides logic for creating sitemap.xml file
 *
 * @package app\models
 */
class Sitemap extends Model
{
    /**
     * Collect all urls for sitemap.xml file
     *
     * @return array
     */
    public function getSitemap()
    {
        $urlsAll = [];

        $urlsAll[] = $this->getStaticPages();

        $urlsAll[] = $this->getUrlsMastersIndex();
        $urlsAll[] = $this->getUrlsMastersPerson();

        $urlsAll[] = $this->getUrlsHour();

        $urlsAll[] = $this->getUrlsInformftionIndex();
        $urlsAll[] = $this->getUrlsInformftionFull();

        return $urlsAll;
    }

    /**
     * Collect index master pages for sitemap.xml file
     *
     * @return array
     */
    protected function getUrlsMastersIndex()
    {
        $params['priorityPage1']     = 0.7;
        $params['priorityPageOther'] = 0.6;
        $params['change']            = 'monthly';
        $params['urlTo']             = '/masters/all';
        $params['identifer']         = 'masters';

        $masters = new Masters();

        $pagination = $masters->getPagination(Yii::$app->params['mastersOnPage']);
        $pages      = ceil((int)$pagination->totalCount / $pagination->defaultPageSize);

        $urls = $this->totalCountLinks($pages, $params, 'masters');

        return $urls;
    }

    /**
     * Collect all masters for sitemap.xml file
     *
     * @return array
     */
    protected function getUrlsMastersPerson()
    {
        $priority = 0.8;
        $change   = 'monthly';

        $masters = new Masters();

        $master = $masters->getMastersPagination();

        if (! empty($master)) {
            foreach ($master as $m) {
                $urls['person'][] = [
                    'url'      => Url::to([
                        '/masters/person',
                        'id'   => $m['id'],
                        'name' => strtolower(TranslitHelper::translit($m['name']))
                    ]),
                    'priority' => $priority,
                    'change'   => $change
                ];
            }
        }

        return $urls;
    }

    /**
     * Collect all ads pages for sitemap.xml file
     *
     * @return array
     */
    protected function getUrlsHour()
    {
        $params['priorityPage1']     = 0.7;
        $params['priorityPageOther'] = 0.6;
        $params['change']            = 'monthly';
        $params['urlTo']             = '/site/hour';
        $params['identifer']         = 'hour';

        $hour = new Hour();

        $pagination = $hour->getPagination(Yii::$app->params['hourOnPage']);
        $pages      = ceil((int)$pagination->totalCount / $pagination->defaultPageSize);

        $urls = $this->totalCountLinks($pages, $params);

        return $urls;
    }

    /**
     * Collect all index article pages for sitemap.xml file
     *
     * @return array
     */
    protected function getUrlsInformftionIndex()
    {
        $params['priorityPage1']     = 0.7;
        $params['priorityPageOther'] = 0.6;
        $params['change']            = 'monthly';
        $params['urlTo']             = '/information/index';
        $params['identifer']         = 'information';

        $information = new Information();

        $pagination = $information->getPagination(Yii::$app->params['infoOnPage']);
        $pages      = ceil((int)$pagination->totalCount / $pagination->defaultPageSize);

        $urls = $this->totalCountLinks($pages, $params);

        return $urls;
    }

    /**
     * Collect all articles for sitemap.xml file
     *
     * @return array
     */
    protected function getUrlsInformftionFull()
    {
        $priority = 0.8;
        $change   = 'monthly';

        $informationObj = new Information();

        $information = $informationObj->getAllPosts();

        if (! empty($information)) {
            foreach ($information as $info) {
                $urls['person'][] = [
                    'url'      => Url::to([
                        '/information/information-full',
                        'id'    => $info['id'],
                        'title' => strtolower(TranslitHelper::translit($info['title']))
                    ]),
                    'priority' => $priority,
                    'change'   => $change
                ];
            }
        }

        return $urls;
    }

    /**
     * Create url for pagination pages
     *
     * @param int   $pages  The number of pagination pages
     * @param array $params Params for url
     * @return array
     */
    protected function totalCountLinks($pages, $params)
    {
        $urls = [];

        $urls[$params['identifer']][] = [
            'url'      => Url::to([$params['urlTo']]),
            'priority' => $params['priorityPage1'],
            'change'   => $params['change']
        ];

        for ($i = 2; $i <= $pages; $i++) {
            $urls[$params['identifer']][] = [
                'url'      => Url::to([$params['urlTo'], 'page' => $i]),
                'priority' => $params['priorityPageOther'],
                'change'   => $params['change']
            ];
        }

        return $urls;
    }

    /**
     * Collect all static pages for sitemap.xml file
     *
     * @return array
     */
    protected function getStaticPages()
    {
        $urlsStatic = [];
        $links      = [
            [
                'url'      => Url::to(['site/index']),
                'priority' => 1,
                'change'   => 'monthly'
            ],
            [
                'url'      => Url::to(['site/about']),
                'priority' => 0.9,
                'change'   => 'monthly'
            ],
            [
                'url'      => Url::to(['site/add']),
                'priority' => 0.4,
                'change'   => 'daily'
            ],
            [
                'url'      => Url::to(['site/send-comment']),
                'priority' => 0.4,
                'change'   => 'monthly'
            ],
            [
                'url'      => Url::to(['site/contact']),
                'priority' => 0.4,
                'change'   => 'monthly'
            ],
            [
                'url'      => Url::to(['user/login']),
                'priority' => 0.4,
                'change'   => 'monthly'
            ],
            [
                'url'      => Url::to(['user/registration']),
                'priority' => 0.4,
                'change'   => 'monthly'
            ],
            [
                'url'      => Url::to(['masters/enter']),
                'priority' => 0.6,
                'change'   => 'monthly'
            ]
        ];

        if (! empty($links)) {
            foreach ($links as $link) {
                $urlsStatic['static'][] = [
                    'url'      => $link['url'],
                    'priority' => $link['priority'],
                    'change'   => $link['change']
                ];
            }
        }

        return $urlsStatic;
    }
}
