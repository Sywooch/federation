<?
namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\web\UploadedFile;
use yii\helpers\TranslitHelper;

/**
 * Class AdminInformation provides logic for handling articles from admin panel
 *
 * @package app\modules\admin\models
 */
class AdminInformation extends Model
{
    /**
     * @var int The number of images for the article
     */
    protected $countImgs = 20;
    /**
     * @var string Filename in latin
     */
    public $name;

    /**
     * @var string Title for article
     */
    public $title;

    /**
     * @var string Short description for article
     */
    public $short;

    /**
     * @var string Full article text
     */
    public $full;

    /**
     * @var string|int Mode for upload images
     */
    public $mode;

    /**
     * @var UploadedFile If were load files
     */
    public $file;
    public $file1;
    public $file2;
    public $file3;
    public $file4;
    public $file5;
    public $file6;
    public $file7;
    public $file8;
    public $file9;
    public $file10;
    public $file11;
    public $file12;
    public $file13;
    public $file14;
    public $file15;
    public $file16;
    public $file17;
    public $file18;
    public $file19;
    public $file20;

    /**
     * Rules for form validation
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['title',
             'required',
             'message' => 'Поле должно быть заполненным'
            ],
            ['title',
             'string', 'max' => 100,
             'tooLong'       => 'Максимальная длина 100 символов, у Вас больше'
            ]
        ];
    }

    /**
     * Preview for article
     *
     * @param array $post Input values
     * @return array
     */
    public function previewInformation($post)
    {
        for ($i = 1; $i <= $this->countImgs; $i++) {
            $variable                 =
                $this->moveUploadedFile('file' . $i, $post['AdminInformation']['title'], 'toTemp');
            $currentPost['file' . $i] = $variable;
        }

        $this->checkStrLen($post['full'], $post['short']);

        $currentPost['full_text'] = $post['full'];
        $currentPost['title']     = $post['AdminInformation']['title'];

        return $currentPost;
    }

    /**
     * Insert new article
     *
     * @param array $post Input values
     * @return array Array with uploaded filename
     */
    public function insertInformation($post)
    {
        $this->checkStrLen($post['full'], $post['short']);

        $this->deleteTempFiles(); // after preview

        $nameFileArray = [];
        for ($j = 0; $j <= $this->countImgs; $j++) {
            $j == 0 ? $i = '' : $i = $j;
            $nameFileArray['file' . $i] = $this->moveUploadedFile('file' . $i, $post['AdminInformation']['title']);
        }

        $nameFileArray = $this->insertNewPost($post, $nameFileArray);

        return $nameFileArray;
    }

    /**
     * Insert new article in database
     *
     * @param array $post          Input values
     * @param array $nameFileArray Array with uploaded filename
     * @return array Array with uploaded filename
     * @throws \yii\db\Exception
     */
    public function insertNewPost($post, $nameFileArray)
    {
        $short = htmlspecialchars($post['short'], ENT_QUOTES, 'UTF-8');
        $full  = htmlspecialchars($post['full'], ENT_QUOTES, 'UTF-8');

        $db = Yii::$app->db;

        $params = [
            ':title'        => $post['AdminInformation']['title'],
            ':short'        => $short,
            ':fullText'     => $full,
            ':nameTranslit' => $this->name,
        ];
        for ($j = 0; $j <= $this->countImgs; $j++) {
            ($j == 0) ? $i = '' : $i = $j;
            $params[':file' . $i] = $nameFileArray['file' . $i];
        }

        $db->createCommand(
            "INSERT INTO information (
                title,
                short_text,
                full_text,
                name_translit,
                file,
                file1,
                file2,
                file3,
                file4,
                file5,
                file6,
                file7,
                file8,
                file9,
                file10,
                file11,
                file12,
                file13,
                file14,
                file15,
                file16,
                file17,
                file18,
                file19,
                file20
            )
            VALUES (
                :title,
                :short,
                :fullText,
                :nameTranslit,
                :file,
                :file1,
                :file2,
                :file3,
                :file4,
                :file5,
                :file6,
                :file7,
                :file8,
                :file9,
                :file10,
                :file11,
                :file12,
                :file13,
                :file14,
                :file15,
                :file16,
                :file17,
                :file18,
                :file19,
                :file20
            )"
        )
            ->bindValues($params)
            ->execute();

        return $nameFileArray;
    }

    /**
     * @param array $post          Input values
     * @param array $currentInform Selected article
     * @param int   $id            Article id
     * @return array Array with uploaded filename
     */
    public function updateInformation($post, $currentInform, $id)
    {
        $this->checkStrLen($post['full'], $post['short']);

        $this->deleteTempFiles(); // after preview

        $nameFileArray = [];
        for ($j = 0; $j <= $this->countImgs; $j++) {
            $j == 0 ? $i = '' : $i = $j;

            $nameFileArray['file' . $i] = $this->moveUploadedFile('file' . $i, $post['AdminInformation']['title']);

            if (
                is_null($nameFileArray['file' . $i])
                and ! is_null($currentInform['file' . $i])
                    and ! $post['deletePhoto' . $i]
            ) {
                $nameFileArray['file' . $i] = $currentInform['file' . $i];
            }
        }

        $this->deleteUnusedImg($currentInform, $nameFileArray);

        $this->updatePost($post, $nameFileArray, $id);

        return $nameFileArray;
    }

    /**
     * Update article
     *
     * @param array $post          Input values
     * @param array $nameFileArray Array with uploaded filename
     * @param int   $id            Article id
     * @throws \yii\db\Exception
     */
    public function updatePost($post, $nameFileArray, $id)
    {

        $short = htmlspecialchars($post['short'], ENT_QUOTES, 'UTF-8');
        $full  = htmlspecialchars($post['full'], ENT_QUOTES, 'UTF-8');

        $db = Yii::$app->db;

        $params = [
            'title'      => $post['AdminInformation']['title'],
            'short_text' => $short,
            'full_text'  => $full
        ];
        for ($j = 0; $j <= $this->countImgs; $j++) {
            ($j == 0) ? $i = '' : $i = $j;
            $params['file' . $i] = $nameFileArray['file' . $i];
        }

        $db->createCommand()
            ->update('information', $params,
                'id = ' . $id)
            ->execute();
    }

    /**
     * Prepare images for preview mode
     *
     * @param array $currentPost   Selected article in preview mode
     * @param array $currentInform Selected article
     * @param array $post          Input values
     * @return array
     */
    public function prepareImgs($currentPost, $currentInform, $post)
    {
        for ($i = 1; $i <= $this->countImgs; $i++) {
            if (is_null($currentPost['file' . $i]) and
                ! is_null($currentInform['file' . $i]) and
                ! $post['deletePhoto' . $i]
            ) {
                $currentPost['file' . $i] = $currentInform['file' . $i];
            }
        }

        return $currentPost;
    }

    /**
     * Move uploaded files
     *
     * @param string      $file Field name for file
     * @param string      $name Title of article
     * @param null|string $mode Mode for upload images
     * @return null|string
     */
    public function moveUploadedFile($file, $name, $mode = null)
    {
        $this->file = UploadedFile::getInstance($this, $file);
        $this->name = mb_strtolower(TranslitHelper::translit($name), 'UTF-8');
        $nameFile   = null;

        ($mode === 'toTemp') ? $temp = 'temp/' : $temp = '';

        if (is_object($this->file)) {
            $nameFile = 'img/information/' . $temp . $this->name . '--' . uniqid() . '.' . $this->file->extension;
            $this->file->saveAs($nameFile);
        }

        return $nameFile;
    }

    /**
     * Delete temp files
     *
     * @return bool
     */
    public function deleteTempFiles()
    {
        $files = glob('img/information/temp/*');

        array_map('unlink', $files);

        return true;
    }

    /**
     * Delete unused files
     *
     * @param array $currentInform Selected article
     * @param array $nameFileArray Array with uploaded filename
     * @return bool
     */
    public function deleteUnusedImg($currentInform, $nameFileArray)
    {
        for ($j = 0; $j <= $this->countImgs; $j++) {
            ($j == 0) ? $i = '' : $i = $j;
            if (
                $currentInform['file' . $i] != $nameFileArray['file' . $i]
                and is_file($currentInform['file' . $i])
            ) {
                $deleteArray[] = $currentInform['file' . $i];
            }
        }

        if (! empty($deleteArray)) {
            array_map('unlink', $deleteArray);
        }

        return true;
    }

    /**
     * Get all articles
     *
     * @return array
     */
    public function getAllInform()
    {
        $queryBuilder = new Query();
        $articles     = $queryBuilder
            ->select([
                'id',
                'title'
            ])
            ->from('information')
            ->all();

        return $articles;
    }

    /**
     * Delete selected articles
     *
     * @param array $post Input values
     * @return bool
     * @throws \yii\db\Exception
     */
    public function deletePost($post)
    {
        $db = Yii::$app->db;

        if (! empty($post)) {
            foreach ($post as $pKey => $pVal) {
                if (! is_int($pKey)) {
                    continue;
                }

                $this->deletePhotosFromFolder($pKey);

                $db->createCommand()
                    ->delete('information', 'id = ' . $pKey)
                    ->execute();
            }
        }

        return true;
    }

    /**
     * Delete images from folder for selected article
     *
     * @param int $id Article id
     * @return bool
     */
    public function deletePhotosFromFolder($id)
    {
        $queryBuilder = new Query();

        $arr = [];
        for ($j = 0; $j <= $this->countImgs; $j++) {
            ($j == 0) ? $i = '' : $i = $j;
            $arr[] = 'file' . $i;
        }

        $photos = $queryBuilder
            ->select($arr)
            ->from('information')
            ->where(['id' => $id])
            ->one();

        if (! empty($photos)) {
            foreach ($photos as $photo) {
                if (is_file($photo)) {
                    unlink($photo);
                }
            }
        }

        return true;
    }


    /**
     * Check length of full and short texts
     *
     * @param string $full  Full text
     * @param string $short Short text
     * @return bool
     */
    public function checkStrLen($full, $short)
    {
        if (strlen(htmlspecialchars($full)) > 140000) {
            echo 'Полное описание слишкомм длинное, сократите, пожалуста.';
            exit;
        }
        if (strlen(htmlspecialchars($short)) > 4000) {
            echo 'Краткое описание слишкомм длинное, сократите, пожалуста.';
            exit;
        }

        return true;
    }

    /**
     * Get article by id
     *
     * @param int $id Article id
     * @return array|bool
     */
    public function getCurrentInform($id)
    {
        $queryBuilder = new Query();

        $arr = [
            'title',
            'short_text',
            'full_text'
        ];
        for ($j = 0; $j <= $this->countImgs; $j++) {
            ($j == 0) ? $i = '' : $i = $j;
            $arr[] = 'file' . $i;
        }

        $currentInform = $queryBuilder
            ->select($arr)
            ->from('information')
            ->where(['id' => $id])
            ->one();

        $this->title = $currentInform['title'];
        $this->short = htmlspecialchars_decode($currentInform['short_text']);
        $this->full  = htmlspecialchars_decode($currentInform['full_text']);
        $this->file  = $currentInform['file'];

        $this->mode = 1;

        return $currentInform;
    }
}
