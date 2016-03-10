<?
namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\web\UploadedFile;

/**
 * Class AdminMasters provides logic for handling masters from admin panel
 *
 * @package app\modules\admin\models
 */
class AdminMasters extends Model
{
    /**
     * @var string Master name
     */
    public $name;

    /**
     * @var String Master city
     */
    public $city;

    /**
     * @var String Master telephone
     */
    public $tel;

    /**
     * @var String Master email
     */
    public $email;

    /**
     * @var String Master location
     */
    public $location;

    /**
     * @var String Master short history
     */
    public $history_short;

    /**
     * @var String Master full history
     */
    public $history;

    /**
     * @var String Master experience
     */
    public $expirience;

    /**
     * @var String Master command
     */
    public $friends;

    /**
     * @var String Master business status
     */
    public $status;

    /**
     * @var String Master age
     */
    public $age;

    /**
     * @var String Master currency
     */
    public $money;

    /**
     * @var String Master id
     */
    public $id;

    /**
     * @var String Master file with avatar
     */
    public $avatar;

    /**
     * @var String Message for sending to master
     */
    public $messageForMasters;

    /**
     * @var UploadedFile If were load files
     */
    public $file1;
    public $file2;
    public $file3;
    public $file4;
    public $file5;

    /**
     * Rules for form validation
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'city', 'status', 'history_short', 'history'],
             'required',
             'message' => 'Это поле обязательно для заполнения'
            ],
            ['email',
             'email',
             'message' => 'Введите реальный Email, например client@mail.ru'
            ],
            [['city', 'name'],
             'string', 'max' => 80,
             'tooLong'       => 'Максимальная длина 80 символов, у Вас больше'
            ],
            [['tel', 'email', 'status', 'age', 'money', 'friends'],
             'string', 'max' => 30,
             'tooLong'       => 'Максимальная длина 30 символов, у Вас больше'
            ],
            ['location',
             'string', 'max' => 100,
             'tooLong'       => 'Максимальная длина 100 символов, у Вас больше'
            ],
            ['history_short',
             'string', 'max' => 1000,
             'tooLong'       => 'Максимальная длина 1000 символов, у Вас больше'
            ],
            ['history',
             'string', 'max' => 2000,
             'tooLong'       => 'Максимальная длина 2000 символов, у Вас больше'
            ]
        ];
    }

    /**
     * Get all masters from database
     *
     * @return array
     */
    public function getAllMasters()
    {
        $queryBuilder = new Query();
        $masters      = $queryBuilder
            ->select([
                'id',
                'name',
                'status'
            ])
            ->from('masters')
            ->all();

        return $masters;
    }

    /**
     * Get master by id
     *
     * @param int $id Master id
     * @return array|bool
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
                'location',
                'avatar',
                'history',
                'expirience',
                'friends',
                'status',
                'age',
                'history_short',
                'money'
            ])
            ->from('masters')
            ->where(['id' => $id])
            ->one();

        return $master;
    }

    /**
     * Get all services
     *
     * @return array
     */
    public function getAllServices()
    {
        $queryBuilder = new Query();
        $services     = $queryBuilder
            ->select([
                'services.id',
                'type_services.name',
                'services.name_services',
            ])
            ->from('services')
            ->join('INNER JOIN', 'type_services', 'services.type = type_services.id')
            ->all();

        return $services;
    }

    /**
     * Get services for selected master
     *
     * @param int $idMaster Master id
     * @return array
     */
    public function getMasterServices($idMaster)
    {
        $queryBuilder   = new Query();
        $masterServices = $queryBuilder
            ->select([
                'id_service'
            ])
            ->from('master_services')
            ->where(['id_master' => $idMaster])
            ->all();

        return $masterServices;
    }

    /**
     * Get work photos of the master
     *
     * @param int $idMaster Master id
     * @return array
     */
    public function getMasterFotos($idMaster)
    {
        $queryBuilder = new Query();
        $masterFotos  = $queryBuilder
            ->select([
                'id',
                'foto_url'
            ])
            ->from('foto')
            ->where(['id_master' => $idMaster])
            ->all();

        return $masterFotos;
    }

    /**
     * Get comments about master
     *
     * @param int $idMaster Master id
     * @return array
     */
    public function getMasterComments($idMaster)
    {
        $queryBuilder   = new Query();
        $masterComments = $queryBuilder
            ->select([
                'id_comment',
                'text',
                'side',
                'users.fio',
                'users.id',
                'users.username',
                'date_comment'
            ])
            ->from('comments')
            ->where(['id_master' => $idMaster])
            ->join('INNER JOIN', 'users', 'comments.user_id = users.id')
            ->orderBy(['id_comment' => SORT_DESC])
            ->all();

        return $masterComments;
    }

    /**
     * Update master
     *
     * @param array $post Input values
     * @return bool
     * @throws \yii\db\Exception
     */
    public function insertModifyData($post)
    {
        $folderInImgDir = 'avatar';
        $nameFile       = $this->moveUploadedFile('avatar', $post['avatarPrevious'], $folderInImgDir);

        if ($post['avatarPrevious'] and $nameFile != $post['avatarPrevious']) {
            unlink($post['avatarPrevious']);
        }

        $db = Yii::$app->db;

        $this->updateTableWithMaster($db, $post, $nameFile);

        $this->updateMasterServices($db, $post);

        $this->deleteChosenPhotos($db, $post['fotos']);

        $this->deleteChosenComments($db, $post['comment']);

        $this->insertNewPhotos($db, $post);

        return true;
    }

    /**
     * Update table with masters
     *
     * @param object $db   Connection to database
     * @param array  $post Input values
     * @param string $nameFile
     * @throws \yii\db\Exception
     */
    protected function updateTableWithMaster($db, array $post, $nameFile)
    {
        return $db->createCommand()
            ->update('masters', [
                'name'          => $post['AdminMasters']['name'],
                'city'          => $post['AdminMasters']['city'],
                'tel'           => $post['AdminMasters']['tel'],
                'email'         => $post['AdminMasters']['email'],
                'location'      => $post['AdminMasters']['location'],
                'expirience'    => $post['AdminMasters']['expirience'],
                'friends'       => $post['AdminMasters']['friends'],
                'status'        => $post['AdminMasters']['status'],
                'age'           => $post['AdminMasters']['age'],
                'money'         => $post['AdminMasters']['money'],
                'history_short' => htmlspecialchars($post['history_short']),
                'history'       => htmlspecialchars($post['history']),
                'avatar'        => $nameFile
            ],
                'id = ' . $post['id'])
            ->execute();
    }

    /**
     * Update master services
     * Delete all services and insert only checked
     *
     * @param object $db   Connection to database
     * @param array  $post Input values
     */
    protected function updateMasterServices($db, $post)
    {
        $this->deleteMastersServices($db, $post['id']);

        $this->insertCheckedServicesForMaster($db, $post);
    }

    /**
     * Delete all services for master
     *
     * @param object $db Connection to database
     * @param int    $id Master id
     * @return bool
     */
    protected function deleteMastersServices($db, $id)
    {
        return $db->createCommand()
            ->delete('master_services', 'id_master = ' . $id)
            ->execute();
    }

    /**
     * Insert selected services for master
     *
     * @param object $db   Connection to database
     * @param array  $post Input values
     * @return bool
     */
    protected function insertCheckedServicesForMaster($db, $post)
    {
        $arr = [];
        if (! empty($post['services'])) {
            foreach ($post['services'] as $sKey => $sVal) {
                $arr[] = [$post['id'], $sKey];
            }

            return $db->createCommand()
                ->batchInsert('master_services', ['id_master', 'id_service'], $arr)
                ->execute();
        }

        return true;
    }

    /**
     * Delete selected photos of the work
     *
     * @param object $db     Connection to database
     * @param array  $photos Selected photos for deleting
     * @return bool
     */
    protected function deleteChosenPhotos($db, $photos)
    {
        if (! empty($photos)) {
            $this->deleteFotoFromFolder($photos);
            foreach ($photos as $fotoId => $fotoVal) {
                if ($fotoVal) {
                    $db->createCommand()
                        ->delete('foto', 'id = ' . $fotoId)
                        ->execute();
                }
            }
        }

        return true;
    }

    /**
     * Delete selected photos of the work from directory
     *
     * @param array $photos Selected photos for deleting
     * @return bool
     */
    public function deleteFotoFromFolder($photos)
    {
        $deleteFotoArray = array_keys($photos, '1');
        $queryBuilder    = new Query();
        $fotoUrls        = $queryBuilder
            ->select('foto_url')
            ->from('foto')
            ->where(['id' => $deleteFotoArray])
            ->all();

        $fotoUrlsFinal = [];
        if (! empty($fotoUrls)) {
            foreach ($fotoUrls as $fu) {
                if (is_file($fu['foto_url'])) {
                    $fotoUrlsFinal[] = $fu['foto_url'];
                }
            }
        }

        if (! empty($fotoUrlsFinal)) {
            array_map('unlink', $fotoUrlsFinal);
        }

        return true;
    }

    /**
     * Delete selected comments from database
     *
     * @param object $db       Connection to database
     * @param array  $comments Selected comments for deleting
     */
    protected function deleteChosenComments($db, $comments)
    {
        if (! empty($comments)) {
            foreach ($comments as $commentId => $commentVal) {
                if ($commentVal) {
                    $db->createCommand()
                        ->delete('comments', 'id_comment = ' . $commentId)
                        ->execute();
                }
            }
        }
    }

    /**
     * Delete selected comments from database
     *
     * @param object $db   Connection to database
     * @param array  $post Input values
     */
    protected function insertNewPhotos($db, $post)
    {
        $folderInImgDir = 'foto';

        $arrToInsertFotos = [];
        for ($i = 1; $i <= 5; $i++) {
            $variable = $this->moveUploadedFile('file' . $i, null, $folderInImgDir);
            if (! is_null($variable)) {
                $arrToInsertFotos[$i][] = $post['id'];
                $arrToInsertFotos[$i][] = $variable;
            }
        }

        if (! empty($arrToInsertFotos)) {
            $db->createCommand()
                ->batchInsert('foto', ['id_master', 'foto_url'], $arrToInsertFotos)
                ->execute();
        }
    }

    /**
     * Move uploaded files
     *
     * @param string      $file           Field name for file
     * @param string|null $default        Default filename
     * @param null|string $folderInImgDir Directory for uploading files
     * @return null|string
     */
    public function moveUploadedFile($file, $default = null, $folderInImgDir)
    {
        $this->avatar = UploadedFile::getInstance($this, $file);
        $nameFile     = null;
        if (is_object($this->avatar)) {
            $nameFile = 'img/' . $folderInImgDir . '/' . date('y-m-d_H-i-s')
                        . '--' . uniqid() . '.' . $this->avatar->extension;
            $this->avatar->saveAs($nameFile);
        } else {
            $nameFile = $default;
        }

        return $nameFile;
    }

    /**
     * Delete master
     *
     * @param int $id Master id
     * @return bool
     * @throws \yii\db\Exception
     */
    public function deleteMaster($id)
    {
        $db = Yii::$app->db;

        $this->deleteAvatar($id);

        $this->deleteFoto($id);

        $db->createCommand()
            ->delete('comments', 'id_master = ' . $id)
            ->execute();

        $db->createCommand()
            ->delete('foto', 'id_master = ' . $id)
            ->execute();

        $db->createCommand()
            ->delete('master_services', 'id_master = ' . $id)
            ->execute();

        $db->createCommand()
            ->delete('masters', 'id = ' . $id)
            ->execute();

        return true;
    }

    /**
     * Delete avatar
     *
     * @param int $id Master id
     * @return bool
     */
    public function deleteAvatar($id)
    {
        $queryBuilder = new Query();

        $avatarUrl = $queryBuilder
            ->select('avatar')
            ->from('masters')
            ->where(['id' => $id])
            ->one();

        unlink($avatarUrl['avatar']);

        return true;
    }

    /**
     * Delete photo of the work for master
     *
     * @param int $id Master id
     * @return bool
     */
    public function deleteFoto($id)
    {
        $queryBuilder = new Query();

        $fotoUrls = $queryBuilder
            ->select('foto_url')
            ->from('foto')
            ->where(['id_master' => $id])
            ->all();

        $fotoUrlsFinal = [];
        if (! empty($fotoUrls)) {
            foreach ($fotoUrls as $fu) {
                if (is_file($fu['foto_url'])) {
                    $fotoUrlsFinal[] = $fu['foto_url'];
                }
            }
        }

        if (! empty($fotoUrlsFinal)) {
            array_map('unlink', $fotoUrlsFinal);
        }

        return true;
    }

    /**
     * Insert new master
     *
     * @param array $post Input values
     * @throws \yii\db\Exception
     */
    public function insertNewMaster($post)
    {
        $folderInImgDir = 'avatar';
        $nameFile       = $this->moveUploadedFile('avatar', null, $folderInImgDir);

        $db = Yii::$app->db;

        // insert into masters
        $params = [
            ':name'          => $post['AdminMasters']['name'],
            ':city'          => $post['AdminMasters']['city'],
            ':tel'           => $post['AdminMasters']['tel'],
            ':email'         => $post['AdminMasters']['email'],
            ':location'      => $post['AdminMasters']['location'],
            ':history'       => htmlspecialchars($post['history']),
            ':expirience'    => $post['AdminMasters']['expirience'],
            ':friends'       => $post['AdminMasters']['friends'],
            ':status'        => $post['AdminMasters']['status'],
            ':age'           => $post['AdminMasters']['age'],
            ':history_short' => htmlspecialchars($post['history_short']),
            ':money'         => $post['AdminMasters']['money'],
            ':avatar'        => $nameFile
        ];

        $db->createCommand(
            "INSERT INTO masters (
                name,
                city,
                tel,
                email,
                location,
                history,
                expirience,
                friends,
                status,
                age,
                history_short,
                money,
                avatar
            )
            VALUES (
                :name,
                :city,
                :tel,
                :email,
                :location,
                :history,
                :expirience,
                :friends,
                :status,
                :age,
                :history_short,
                :money,
                :avatar
            )"
        )
            ->bindValues($params)
            ->execute();

        $queryBuilder    = new Query();
        $idCurrentMaster = $queryBuilder
            ->select('id')
            ->from('masters')
            ->where([
                'name' => $post['AdminMasters']['name'],
                'tel'  => $post['AdminMasters']['tel']
            ])
            ->one();

        $folderInImgDir   = 'foto';
        $arrToInsertFotos = [];

        for ($i = 1; $i <= 5; $i++) {
            $variable = $this->moveUploadedFile('file' . $i, null, $folderInImgDir);
            if (! is_null($variable)) {
                $arrToInsertFotos[$i][] = $idCurrentMaster['id'];
                $arrToInsertFotos[$i][] = $variable;
            }
        }

        // insert photos
        if (count($arrToInsertFotos)) {
            $db->createCommand()
                ->batchInsert('foto', ['id_master', 'foto_url'], $arrToInsertFotos)
                ->execute();
        }

        // insert checked services
        if (! empty($post['services'])) {
            $arr = [];
            foreach ($post['services'] as $sKey => $sVal) {
                $arr[] = [$idCurrentMaster['id'], $sKey];
            }
            $db->createCommand()
                ->batchInsert('master_services', ['id_master', 'id_service'], $arr)
                ->execute();
        }
    }

    /**
     * Get all users
     *
     * @return array
     */
    public function getAllUsers()
    {
        $queryBuilder = new Query();

        $users = $queryBuilder
            ->select([
                'id',
                'username',
                'fio'
            ])
            ->from('users')
            ->all();

        return $users;
    }

    /**
     * Send message for masters
     *
     * @param array $post Input values
     * @return array
     */
    public function sendMessage($post)
    {
        $foWho = [];
        if (! empty($post)) {
            foreach ($post as $pKey => $pVal) {
                if (is_int($pKey)) {
                    $foWho[] = $pKey;
                }
            }
        }

        $queryBuilder = new Query();
        $emails       = $queryBuilder
            ->select([
                'email',
                'name'
            ])
            ->from('masters')
            ->where(['id' => $foWho])
            ->all();

        $emailsFinal = [];
        if (! empty($emails)) {
            foreach ($emails as $e) {
                $emailsFinal[] = $e['email'];
            }
        }

        Yii::$app->mailer->compose('mail_masters', [
            'message' => $post['messageForMasters']
        ])
            ->setFrom([Yii::$app->params['adminEmail'] => 'Администрация'])
            ->setTo($emailsFinal)
            ->setSubject('Администрация "Федерации Профессиональных Строителей"')
            ->send();

        return $emails;
    }
}
