<?
namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\data\Pagination;

/**
 * Class Orders provides logic for handling orders from admin panel
 *
 * @package app\modules\admin\models
 */
class Orders extends Model
{
    /**
     * @var Query Select all orders
     */
    protected $query;

    /**
     * @var Pagination for $this->query request
     */
    protected $pagination;

    /**
     * Rules for form validation
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['header', 'clientName', 'clientTel', 'clientEmail', 'captcha'],
             'required',
             'message' => 'Поле должно быть заполненным'
            ],
            ['clientEmail',
             'email',
             'message' => 'Введите реальный Email, например client@mail.ru'
            ],
            ['captcha',
             'captcha',
             'message' =>
                 'Символы введены не верно, проверьте пожалуйста, или обновите картинку и попробуйте еще раз'
            ],
            ['header',
             'string', 'max' => 500,
             'tooLong'       => 'Максимальная длина 500 символов, у Вас больше'
            ],
            ['more',
             'string', 'max' => 5000,
             'tooLong'       => 'Максимальная длина 5000 символов, у Вас больше'
            ],
            [['dateToStartWorking', 'clientName'],
             'string', 'max' => 100,
             'tooLong'       => 'Максимальная длина 100 символов, у Вас больше'
            ],
            ['location',
             'string', 'max' => 200,
             'tooLong'       => 'Максимальная длина 200 символов, у Вас больше'
            ],
            [['clientTel', 'clientEmail'],
             'string', 'max' => 50,
             'tooLong'       => 'Максимальная длина 50 символов, у Вас больше'
            ]
        ];
    }

    /**
     * Create request for select all orders from database
     * Set $this->query variable
     */
    protected function getQueryOrders()
    {
        $queryBuilder = new Query();
        $this->query  = $queryBuilder
            ->select([
                'orders.id',
                'orders.header',
                'orders.text_order',
                'orders.start',
                'orders.location',
                'orders.client_name',
                'orders.tel',
                'orders.email',
                'orders.file',
                'orders.file2',
                'orders.file3',
                'orders.file4',
                'orders.file5',
                'orders.date_orders',
                'type_services.name AS type_services_name',
                'services.name_services',
                'masters.name AS master_name',
                'order_status.status_name'
            ])
            ->from('orders')
            ->join('INNER JOIN', 'services', 'orders.type_work_value = services.id')
            ->join('INNER JOIN', 'type_services', 'services.type = type_services.id')
            ->join('INNER JOIN', 'masters', 'orders.master_responsible = masters.id')
            ->join('INNER JOIN', 'order_status', 'orders.status = order_status.id_status')
            ->orderBy(['orders.id' => SORT_DESC]);
    }

    /**
     * Create pagination for all orders
     *
     * @param int $ordersOnPage Number of orders on the page
     * @return Pagination
     */
    public function getPagination($ordersOnPage)
    {
        if (! $this->query) {
            $this->getQueryOrders();
        }

        return $this->pagination = new Pagination([
            'defaultPageSize' => $ordersOnPage,
            'pageSizeLimit'   => [1, $ordersOnPage],
            'totalCount'      => $this->query->count(),
        ]);
    }

    /**
     * Get all orders
     *
     * @return array
     */
    public function getAllOrders($ordersOnPage)
    {
        if (! $this->query) {
            $this->getQueryOrders();
        }

        return $orders = $this->query
            ->offset($this->pagination->offset)
            ->limit($ordersOnPage)
            ->all();
    }

    /**
     * Get orders, that have been received today
     *
     * @return array
     */
    public function getTodayOrders()
    {
        if (! $this->query) {
            $this->getQueryOrders();
        }

        $currentDate = date('Y-m-d 00:00:01');

        return $orders = $this->query
            ->where(['>', 'date_orders', $currentDate])
            ->all();
    }

    /**
     * Get order by id
     *
     * @param int $id Order id
     * @return array|bool
     */
    public function getOrderById($id)
    {
        $queryBuilder = new Query();

        $order = $queryBuilder
            ->select([
                'orders.id',
                'orders.header',
                'orders.text_order',
                'orders.start',
                'orders.location',
                'orders.client_name',
                'orders.tel',
                'orders.email',
                'orders.file',
                'orders.file2',
                'orders.file3',
                'orders.file4',
                'orders.file5',
                'orders.date_orders',
                'orders.master_responsible',
                'type_services.name AS type_services_name',
                'type_services.label_services AS type_services_label',
                'services.name_services',
                'services.id AS services_id',
                'masters.name AS master_name',
                'order_status.status_name',
                'order_status.id_status'
            ])
            ->from('orders')
            ->join('INNER JOIN', 'services', 'orders.type_work_value = services.id')
            ->join('INNER JOIN', 'type_services', 'services.type = type_services.id')
            ->join('INNER JOIN', 'masters', 'orders.master_responsible = masters.id')
            ->join('INNER JOIN', 'order_status', 'orders.status = order_status.id_status')
            ->where(['orders.id' => $id])
            ->one();

        return $order;
    }

    /**
     * Get all statuses for orders
     *
     * @return array
     */
    public function getStatuses()
    {
        $queryBuilder = new Query();
        $statuses     = $queryBuilder
            ->select([
                'id_status',
                'status_name'
            ])
            ->from('order_status')
            ->all();

        return $statuses;
    }

    /**
     * Update order
     *
     * @param array $post Input values from user
     * @return bool
     * @throws \yii\db\Exception
     */
    public function insertModifyData($post)
    {
        $db = Yii::$app->db;

        $db->createCommand()
            ->update('orders', [
                'type_work_value'    => $post['selectValueName'],
                'type_work_category' => $post['selectValueType'],
                'header'             => $post['Orders']['header'],
                'text_order'         => $post['more'],
                'start'              => $post['Orders']['start'],
                'location'           => $post['Orders']['location'],
                'client_name'        => $post['Orders']['clientName'],
                'tel'                => $post['Orders']['tel'],
                'email'              => $post['Orders']['email'],
                'master_responsible' => $post['Orders']['masterResponsible'],
                'status'             => $post['Orders']['statuses']
            ],
                'id = ' . $post['id'])
            ->execute();

        return true;
    }

    /**
     * Delete order by id
     *
     * @param int $id Order id
     * @return bool
     * @throws \yii\db\Exception
     */
    public function deleteOrderById($id)
    {
        $queryBuilder = new Query();
        $fotoLinks    = $queryBuilder
            ->select([
                'file',
                'file2',
                'file3',
                'file4',
                'file5'
            ])
            ->from('orders')
            ->where(['id' => $id])
            ->one();

        $fotoLinksFinal = [];
        if (! empty($fotoLinks)) {
            foreach ($fotoLinks as $fotoLink) {
                if (is_file($fotoLink)) {
                    $fotoLinksFinal[] = $fotoLink;
                }
            }
        }
        if (! empty($fotoLinksFinal)) {
            array_map('unlink', $fotoLinksFinal);
        }

        $db = Yii::$app->db;

        return $db->createCommand()
            ->delete('orders', 'id = ' . $id)
            ->execute();
    }
}
