<?
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\data\Pagination;

/**
 * Class Hour provides logic for 'Man on hour' page
 *
 * @package app\models
 */
class Hour extends Model
{
    /**
     * @var Query Select all rows with ad or search result
     */
    protected $query;

    /**
     * @var Pagination for $this->query request
     */
    protected $pagination;

    /**
     * @var string Search request
     */
    public $search;

    /**
     * Create request for select all ads from database
     * Set $this->query variable
     */
    public function getQuery()
    {
        $queryBuilder = new Query();
        $this->query  = $queryBuilder
            ->select([
                'id',
                'name_man',
                'header',
                'text',
                'tel',
                'email',
                'location',
                'date_hour'
            ])
            ->from('hour')
            ->orderBy(['date_hour' => SORT_DESC]);
    }

    /**
     * Create pagination for all ads
     *
     * @param int $postsOnPage Number of ads on the page
     * @return Pagination
     */
    public function getPagination($postsOnPage)
    {
        if (! $this->query) {
            $this->getQuery();
        }

        return $this->pagination = new Pagination([
            'defaultPageSize' => $postsOnPage,
            'totalCount'      => $this->query->count()
        ]);
    }

    /**
     * Get all ads
     *
     * @return array
     */
    public function getAllHours()
    {
        if (! $this->query) {
            $this->getQuery();
        }

        return $hour = $this->query
            ->offset($this->pagination->offset)
            ->limit($this->pagination->limit)
            ->all();
    }

    /**
     * Get ads according to search request
     *
     * @param string $str Search request
     * @return array
     */
    public function search($str)
    {
        $queryBuilder = new Query();

        $str = trim(strip_tags($str));

        $hours = $this->query = $queryBuilder
            ->select([
                'id',
                'name_man',
                'header',
                'text',
                'tel',
                'email',
                'location',
                'date_hour'
            ])
            ->from('hour')
            ->orderBy(['date_hour' => SORT_DESC])
            ->where(['like', 'header', $str])
            ->orWhere(['like', 'text', $str])
            ->orWhere(['like', 'name_man', $str])
            ->orWhere(['like', 'tel', $str])
            ->orWhere(['like', 'email', $str])
            ->orWhere(['like', 'location', $str])
            ->all();

        return $hours;
    }
}
