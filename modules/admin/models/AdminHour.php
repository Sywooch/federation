<?
namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\db\Query;

/**
 * Class AdminHour provides logic for handling ads from admin panel
 *
 * @package app\modules\admin\models
 */
class AdminHour extends Model
{
    /**
     * @var string Input value from 'header' field. Header for ad
     */
    public $header;

    /**
     * @var string Input value from 'text' field. Ad description
     */
    public $text;

    /**
     * @var string Input value from 'name' field. Master name
     */
    public $name;

    /**
     * @var string Input value from 'tel' field. Master telephone
     */
    public $tel;

    /**
     * @var string Input value from 'email' field. Master email
     */
    public $email;

    /**
     * @var string Input value from 'location' field. Master location
     */
    public $location;

    /**
     * Rules for form validation
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'header', 'text', 'tel'],
             'required',
             'message' => 'Поле должно быть заполненным'
            ],
            ['email',
             'email',
             'message' => 'Введите реальный Email, например client@mail.ru'
            ],
            ['header',
             'string', 'max' => 200,
             'tooLong'       => 'Максимальная длина 200 символов, у Вас больше'
            ],
            [['name', 'location'],
             'string', 'max' => 50,
             'tooLong'       => 'Максимальная длина 50 символов, у Вас больше'
            ],
            ['text',
             'string', 'max' => 800,
             'tooLong'       => 'Максимальная длина 800 символов, у Вас больше'
            ],
            [['tel', 'email'],
             'string', 'max' => 30,
             'tooLong'       => 'Максимальная длина 30 символов, у Вас больше'
            ]
        ];
    }

    /**
     * Insert new ad
     *
     * @param array $post Input values
     * @throws \yii\db\Exception
     */
    public function insertHour($post)
    {
        $db = Yii::$app->db;

        $params = [
            ':header'   => $post['AdminHour']['header'],
            ':text'     => htmlspecialchars($post['text']),
            ':name'     => $post['AdminHour']['name'],
            ':tel'      => $post['AdminHour']['tel'],
            ':email'    => $post['AdminHour']['email'],
            ':location' => $post['AdminHour']['location']
        ];

        $db->createCommand(
            "INSERT INTO hour (
                header,
                text,
                name_man,
                tel,
                email,
                location
            )
            VALUES (
                :header,
                :text,
                :name,
                :tel,
                :email,
                :location
            )"
        )
            ->bindValues($params)
            ->execute();
    }

    /**
     * Update ad
     *
     * @param array $post Input values
     * @param int   $id   Advert id
     * @throws \yii\db\Exception
     */
    public function updateHour($post, $id)
    {
        $db = Yii::$app->db;

        $db->createCommand()
            ->update('hour', [
                'header'   => $post['AdminHour']['header'],
                'text'     => htmlspecialchars($post['text']),
                'name_man' => $post['AdminHour']['name'],
                'tel'      => $post['AdminHour']['tel'],
                'email'    => $post['AdminHour']['email'],
                'location' => $post['AdminHour']['location']
            ],
                'id = ' . $id)
            ->execute();
    }

    /**
     * Delete ad
     *
     * @param array $post Input values
     * @throws \yii\db\Exception
     */
    public function deleteHour($post)
    {
        $hoursChecked = [];

        if (! empty($post)) {
            foreach ($post as $postKey => $postVal) {
                if (is_integer($postKey)) {
                    $hoursChecked[] = $postKey;
                }
            }
        }

        $db = Yii::$app->db;

        $db->createCommand()
            ->delete('hour', ['id' => $hoursChecked])
            ->execute();
    }

    /**
     * Get all ads
     *
     * @return array
     */
    public function getAllHours()
    {
        $queryBuilder = new Query();

        return $queryBuilder
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
            ->all();
    }

    /**
     * Get selected ad by id
     *
     * @param int $id Advert id
     * @return array|bool
     */
    public function getCurrentHour($id)
    {
        $queryBuilder = new Query();

        $currentHour = $queryBuilder
            ->select([
                'name_man',
                'header',
                'text',
                'tel',
                'email',
                'location'
            ])
            ->from('hour')
            ->where(['id' => $id])
            ->one();

        $this->name     = $currentHour['name_man'];
        $this->header   = $currentHour['header'];
        $this->text     = $currentHour['text'];
        $this->tel      = $currentHour['tel'];
        $this->email    = $currentHour['email'];
        $this->location = $currentHour['location'];

        return $currentHour;
    }

    /**
     * Check for duplicate ad
     *
     * @param array $post Input values
     * @return bool
     */
    public function checkForCopy($post)
    {
        $queryBuilder = new Query();

        $hours = $queryBuilder
            ->select([
                'header',
                'tel'
            ])
            ->from('hour')
            ->all();

        if (! empty($hours)) {
            foreach ($hours as $h) {
                if ($h['header'] == $post['AdminHour']['header']
                    && $h['tel'] == $post['AdminHour']['tel']
                ) {
                    return false;
                }
            }
        }

        return true;
    }
}
