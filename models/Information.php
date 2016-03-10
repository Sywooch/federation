<?
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\data\Pagination;

/**
 * Class Information provides logic for render articles
 *
 * @package app\models
 */
class Information extends Model
{
    /**
     * @var Query Select all rows with articles
     */
    protected $query;

    /**
     * @var Pagination for $this->query request
     */
    protected $pagination;

    /**
     * Create request for select all articles from database
     * Set $this->query variable
     */
    protected function getQueryAllPosts()
    {
        $queryBuilder = new Query();
        $this->query  = $queryBuilder
            ->select([
                'id',
                'name_translit',
                'title',
                'short_text',
                'file'
            ])
            ->from('information')
            ->orderBy(['id' => SORT_DESC]);
    }

    /**
     * Create pagination for all articles
     *
     * @param int $postsOnPage Number of articles on the page
     * @return Pagination
     */
    public function getPagination($postsOnPage)
    {
        if (! $this->query) {
            $this->getQueryAllPosts();
        }

        return $this->pagination = new Pagination([
            'defaultPageSize' => $postsOnPage,
            'totalCount'      => $this->query->count(),
        ]);
    }

    /**
     * Get all articles
     *
     * @return array
     */
    public function getAllPosts()
    {
        if (! $this->query) {
            $this->getQueryAllPosts();
        }

        return $allPosts = $this->query
            ->offset($this->pagination->offset)
            ->limit($this->pagination->limit)
            ->all();
    }

    /**
     * Get full text for selected article
     *
     * @param int $id Article id
     * @return array|bool
     */
    public function getCurrentPost($id)
    {
        $queryBuilder = new Query();

        $arr = [
            'id',
            'name_translit',
            'title',
            'full_text'
        ];
        for ($i = 1; $i <= 20; $i++) {
            $arr[] = 'file' . $i;
        }

        $currentPost = $queryBuilder
            ->select($arr)
            ->where(['id' => $id])
            ->from('information')
            ->one();

        return $currentPost;
    }
}
