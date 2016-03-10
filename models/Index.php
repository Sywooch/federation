<?
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\web\UploadedFile;

/**
 * Class Index provides logic for index page and sending order
 *
 * @package app\models
 */
class Index extends Model
{
    /**
     * @var string Input value from 'header' field. Header for order
     */
    public $header;

    /**
     * @var string Input value from 'more' field. Order description
     */
    public $more;

    /**
     * @var string Input value from 'dateToStartWorking' field. Date to start working
     */
    public $dateToStartWorking;

    /**
     * @var string Input value from 'location' field
     */
    public $location;

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
     * @var UploadedFile If were load file in 'file' field
     */
    public $file;

    /**
     * @var UploadedFile If were load file in 'file2' field
     */
    public $file2;

    /**
     * @var UploadedFile If were load file in 'file3' field
     */
    public $file3;

    /**
     * @var UploadedFile If were load file in 'file4' field
     */
    public $file4;

    /**
     * @var UploadedFile If were load file in 'file5' field
     */
    public $file5;

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
            ],
            [['file', 'file2', 'file3', 'file4', 'file5',],
             'file',
             'extensions' => ['png', 'jpg', 'gif'],
             'maxSize'    => 1024 * 1024 * 2,
             'tooBig'     => 'Максимальный размер файла 2 mb, у Вас больше',
            ]
        ];
    }

    /**
     * Get array with service categories
     *
     * @return array
     */
    public function getLabelTable()
    {
        $labelTables  = [];
        $queryBuilder = new Query();
        $dataServices = $queryBuilder
            ->select([
                'id',
                'name',
                'label_services'
            ])
            ->from('type_services')
            ->all();

        if (! empty($dataServices)) {
            foreach ($dataServices as $ds) {
                $labelTables[$ds['label_services']] = $ds['name'];
            }
        }

        return $labelTables;
    }

    /**
     * Get all services
     *
     * @return array
     */
    public function getServicesLevel()
    {
        $queryBuilder = new Query();

        $query = $queryBuilder
            ->select([
                'services.id',
                'services.type',
                'services.name_services',
                'type_services.name',
                'type_services.label_services'
            ])
            ->from('services')
            ->join('INNER JOIN', 'type_services', 'services.type = type_services.id')
            ->all();

        $servicesLevel = [];
        if (! empty($query)) {
            foreach ($query as $q) {
                if (! $servicesLevel[$q['label_services']]) {
                    $servicesLevel[$q['label_services']]['level']              = $q['name'];
                    $servicesLevel[$q['label_services']]['services'][$q['id']] = $q['name_services'];
                } else {
                    $servicesLevel[$q['label_services']]['services'][$q['id']] = $q['name_services'];
                }
            }
        }

        return $servicesLevel;
    }

    /**
     * Move uploaded file
     *
     * @param string $file Field name with file
     * @return null|string Path to uploaded file
     */
    public function moveUploadedFile($file)
    {
        $this->file = UploadedFile::getInstance($this, $file);
        $nameFile   = null;

        if (is_object($this->file)) {
            // Generate name uploaded file and move them to /uploads/$nameFile
            $nameFile = 'uploads/' . date('y-m-d_H-i-s') . '--' . uniqid() . '.' . $this->file->extension;
            $this->file->saveAs($nameFile);
        }

        return $nameFile;
    }

    /**
     * Insert order
     *
     * @param array $post      Input values from user
     * @param array $nameFiles Array with uploaded files
     * @return string Name service for mailing
     * @throws \yii\db\Exception
     */
    public function insertData($post, $nameFiles)
    {
        $db          = Yii::$app->db;
        $currentDate = date('Y-m-d H:i:s');
        $params      = [
            ':type_work_category' => $post['selectValueType'],
            ':type_work_value'    => $post['selectValueName'],
            ':header'             => $post['Index']['header'],
            ':text_order'         => $post['more'],
            ':start'              => $post['Index']['dateToStartWorking'],
            ':location'           => $post['Index']['location'],
            ':clientName'         => $post['Index']['clientName'],
            ':tel'                => $post['Index']['clientTel'],
            ':email'              => $post['Index']['clientEmail'],
            ':file'               => $nameFiles[0],
            ':file2'              => $nameFiles[1],
            ':file3'              => $nameFiles[2],
            ':file4'              => $nameFiles[3],
            ':file5'              => $nameFiles[4],
            ':date_orders'        => $currentDate
        ];

        $db->createCommand(
            "INSERT INTO orders (
                type_work_category,
                type_work_value,
                header,
                text_order,
                start,
                location,
                client_name,
                tel,
                email,
                file,
                file2,
                file3,
                file4,
                file5,
                date_orders
            )
            VALUES (
                :type_work_category,
                :type_work_value,
                :header,
                :text_order,
                :start,
                :location,
                :clientName,
                :tel,
                :email,
                :file,
                :file2,
                :file3,
                :file4,
                :file5,
                :date_orders
            )"
        )
            ->bindValues($params)
            ->execute();

        return $post['selectValueName'];
    }

    /**
     * Send email to admin after insert a new order
     *
     * @param array $post      Input values from user
     * @param array $nameFiles Array with uploaded files
     */
    public function sendEmail($post, $nameFiles)
    {
        $basePath = Yii::$app->basePath;
        $idOrder  = $this->getIdOrder($post)['id'] + 50000;

        $typeNameServices = $this->getTypeNameServices($post['selectValueType'], $post['selectValueName']);

        $mail = Yii::$app->mailer->compose('mail', [
            'post'             => $post,
            'typeNameServices' => $typeNameServices,
            'idOrder'          => $idOrder
        ])
            ->setFrom($post['Index']['clientEmail'])
            ->setTo(Yii::$app->params['adminEmail'])
            ->setSubject($typeNameServices['type']['name'] . ' - ' . $typeNameServices['name']['name_services']);

        if (! empty($nameFiles)) {
            foreach ($nameFiles as $nameFile) {
                $mail->attach($basePath . '/' . $nameFile);
            }
        }

        $mail->send();
    }

    /**
     * Send email to user after insert a new order
     *
     * @param array $post Input values from user
     */
    public function sendClientEmail($post)
    {
        $typeNameServices = $this->getTypeNameServices($post['selectValueType'], $post['selectValueName']);

        $idOrder = $this->getIdOrder($post)['id'] + 50000;

        Yii::$app->mailer->compose('mail_client', [
            'post'             => $post,
            'typeNameServices' => $typeNameServices,
            'idOrder'          => $idOrder
        ])
            ->setFrom([Yii::$app->params['noReplyEmail'] => 'Федерация Строителей'])
            ->setTo($post['Index']['clientEmail'])
            ->setSubject('Ваша заявка для Федерации Профессиональных Строителей')
            ->send();
    }

    /**
     * Get order id by input values
     *
     * @param array $post Input values from user
     * @return array|bool
     */
    public function getIdOrder($post)
    {
        $queryBuilder = new Query();
        $idOrder      = $queryBuilder
            ->select([
                'id'
            ])
            ->from('orders')
            ->where([
                'type_work_category' => $post['selectValueType'],
                'type_work_value'    => $post['selectValueName'],
                'header'             => $post['Index']['header'],
                'text_order'         => $post['more'],
                'tel'                => $post['Index']['clientTel'],
                'client_name'        => $post['Index']['clientName'],
                'email'              => $post['Index']['clientEmail']
            ])
            ->one();

        return $idOrder;
    }

    /**
     * Get service type and name
     *
     * @param int $selectValueType Type id of selected service
     * @param int $selectValueName Name id of selected service
     * @return array
     */
    public function getTypeNameServices($selectValueType, $selectValueName)
    {
        $typeNameServices = [];
        $queryBuilder     = new Query();

        $typeNameServices['type'] = $queryBuilder
            ->select([
                'name'
            ])
            ->from('type_services')
            ->where(['label_services' => $selectValueType])
            ->one();

        $typeNameServices['name'] = $queryBuilder
            ->select([
                'name_services'
            ])
            ->from('services')
            ->where(['id' => $selectValueName])
            ->one();

        return $typeNameServices;
    }

    /**
     * Get names with path for uploaded files
     *
     * @return array
     */
    public function getFiles()
    {
        $nameFiles = [];
        for ($i = 1; $i <= 5; $i++) {
            ($i == 1) ? $j = '' : $j = $i;
            $variable = $this->moveUploadedFile('file' . $j);
            if ($variable) {
                $nameFiles[] = $variable;
            }
        }

        return $nameFiles;
    }
}
