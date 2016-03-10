<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\data\Pagination;

/**
 * Class Masters provides logic for pages with master info
 * and request for accession in federation
 *
 * @package app\models
 */
class Masters extends Model
{
    /**
     * @var Query Select all masters
     */
    protected $query;

    /**
     * @var Query Select all comments about masters
     */
    protected $queryComments;

    /**
     * @var Pagination for $this->query request
     */
    protected $pagination;

    /**
     * @var Pagination for $this->queryComments request
     */
    protected $paginationComments;

    /**
     * @var string Input value from 'clientName' field. Client name
     */
    public $clientName;

    /**
     * @var string Input value from 'clientTel' field. Client telephone
     */
    public $clientTel;

    /**
     * @var string Input value from 'clientEmail' field. Client email
     */
    public $clientEmail;

    /**
     * @var string Input value from 'more' field. Order description
     */
    public $more;

    /**
     * @var string Input value from captcha field
     */
    public $captcha;

    /**
     * Rules for form validation
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['clientName', 'clientEmail', 'clientTel', 'captcha'],
             'required',
             'message' => 'Поле должно быть заполненным'
            ],
            ['clientEmail',
             'email',
             'message' => 'Введите реальный Email, например client@mail.ru'
            ],
            ['captcha', 'captcha',
             'message' =>
                 'Символы введены не верно, проверьте пожалуйста, или обновите картинку и попробуйте еще раз'
            ],
            [['clientTel', 'clientEmail', 'clientName'],
             'string', 'max' => 50,
             'tooLong'       => 'Максимальная длина 50 символов, у Вас больше'
            ],
            ['more',
             'string', 'max' => 1000,
             'tooLong'       => 'Максимальная длина 1000 символов, у Вас больше'
            ]
        ];
    }

    /**
     * Create request for selecting all masters from database
     * Set $this->query variable
     */
    protected function getQueryMasters()
    {
        $queryBuilder = new Query();
        $this->query  = $queryBuilder
            ->select([
                'id',
                'name',
                'city',
                'tel',
                'email',
                'avatar',
                'history',
                'history_short',
                'expirience',
                'friends',
                'status',
                'age',
                'money'
            ])
            ->from('masters')
            ->where(['not in', 'id', [0]]);
    }

    /**
     * Create pagination for all masters
     *
     * @param int $mastersOnPage The number of masters on the page
     * @return Pagination
     */
    public function getPagination($mastersOnPage)
    {
        if (! $this->query) {
            $this->getQueryMasters();
        }

        return $this->pagination = new Pagination([
            'defaultPageSize' => $mastersOnPage,
            'totalCount'      => $this->query->count()
        ]);
    }

    /**
     * Get all masters
     *
     * @return array
     */
    public function getMastersPagination()
    {
        if (! $this->query) {
            $this->getQueryMasters();
        }

        return $masters = $this->query
            ->offset($this->pagination->offset)
            ->limit($this->pagination->limit)
            ->all();
    }

    /**
     * Create request for selecting master comments from database
     * Set $this->queryComments variable
     */
    protected function getQueryComments()
    {
        $queryBuilder        = new Query();
        $this->queryComments = $queryBuilder
            ->select([
                'id_comment',
                'id_master',
                'text',
                'side',
                'users.id',
                'users.username',
                'users.fio'
            ])
            ->from('comments')
            ->orderBy(['id_comment' => SORT_DESC])
            ->join('INNER JOIN', 'users', 'comments.user_id = users.id');
    }

    /**
     * Create pagination for master comments
     *
     * @param int $commentsOnPage The number of comments on the page
     * @return Pagination
     */
    public function getPaginationComments($commentsOnPage)
    {
        if (! $this->queryComments) {
            $this->getQueryComments();
        }

        return $this->paginationComments = new Pagination([
            'defaultPageSize' => $commentsOnPage,
            'totalCount'      => $this->queryComments->count(),
        ]);
    }

    /**
     * Get comments for selected master with pagination
     *
     * @param int $id Id for selected master
     * @return array
     */
    public function getComments($id)
    {
        if (! $this->queryComments) {
            $this->getQueryComments();
        }

        return $comments = $this->queryComments
            ->where(['id_master' => $id])
            ->offset($this->paginationComments->offset)
            ->limit($this->paginationComments->limit)
            ->all();
    }

    /**
     * Get comments without pagination
     *
     * @param null|int $id Id for selected master
     * @return array
     */
    public function getCommentsAll($id = null)
    {
        if (! $this->queryComments) {
            $this->getQueryComments();
        }

        $comments = $this->queryComments;

        if (! is_null($id)) {
            $comments->where(['id_master' => $id]);
        }

        return $comments->all();
    }

    /**
     * Get master by id
     *
     * @param int $id Master id
     * @return array
     */
    public function getMasterById($id)
    {
        $queryBuilder = new Query();
        $master       = $queryBuilder
            ->select([
                'id',
                'name',
                'city',
                'tel',
                'email',
                'avatar',
                'history',
                'history_short',
                'expirience',
                'friends',
                'status',
                'age',
                'money'
            ])
            ->from('masters')
            ->where(['id' => $id])
            ->all();

        return $master;
    }

    /**
     * Get services for selected master
     *
     * @param null|int $id Master id
     * @return array
     */
    public function getServices($id = null)
    {
        $queryBuilder = new Query();
        $services     = $queryBuilder
            ->select([
                'master_services.id_master',
                'master_services.id_service',
                'services.name_services',
                'services.type',
                'type_services.name',
            ])
            ->from('master_services')
            ->join('INNER JOIN', 'services', 'master_services.id_service = services.id')
            ->join('INNER JOIN', 'type_services', 'services.type = type_services.id');
        if (! is_null($id)) {
            $services->where(['master_services.id_master' => $id]
            );
        }

        return $services->all();
    }

    /**
     * Get all photo for selected master
     *
     * @param null|int $id Master id
     * @return array
     */
    public function getFoto($id = null)
    {
        $queryBuilder = new Query();
        $foto         = $queryBuilder
            ->select([
                'id',
                'id_master',
                'foto_url'
            ])
            ->from('foto');
        if (! is_null($id)) {
            $foto->where(['id_master' => $id]);
        }

        return $foto->all();
    }

    /**
     * Send email to admin with request for accession in federation
     *
     * @param array $post Input values from user
     */
    public function sendEnter($post)
    {
        Yii::$app->mailer
            ->compose(
                'mail_enter', [
                'post' => $post
            ])
            ->setFrom($post['Masters']['clientEmail'])
            ->setTo(Yii::$app->params['adminEmail'])
            ->setSubject('Заявка на мастера')
            ->send();
    }

    /**
     * Send email to user with request for accession in federation
     *
     * @param array $post Input values from user
     */
    public function sendEnterForMaster($post)
    {
        Yii::$app->mailer
            ->compose(
                'mail_enter_master', [
                'post' => $post
            ])
            ->setFrom(Yii::$app->params['noReplyEmail'])
            ->setTo($post['Masters']['clientEmail'])
            ->setSubject('Заявка на мастера')
            ->send();
    }
}
