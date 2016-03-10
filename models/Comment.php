<?
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Query;

/**
 * Class Comment provides logic for sending comments about federation and masters
 *
 * @package app\models
 */
class Comment extends Model
{
    /**
     * @var string Input value from 'more' field. Full comment text
     */
    public $more;

    /**
     * @var string Input value from 'clientName' field. Client name
     */
    public $clientName;

    /**
     * @var string Input value from 'clientEmail' field. Client email
     */
    public $clientEmail;

    /**
     * @var string Input value from captcha field
     */
    public $captcha;

    /**
     * @var string Input value from 'about' field. Master id will take a comment
     */
    public $about;

    /**
     * @var string Input value from 'side' field. Good or bad comment about master
     */
    public $side;

    /**
     * Rules for form validation
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['more', 'clientName', 'clientEmail', 'captcha'],
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
            [['clientName', 'clientEmail'],
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
     * Insert comment about the federation
     *
     * @param array $post Input values from user
     * @throws \yii\db\Exception
     */
    public function insertComment($post)
    {
        $db     = Yii::$app->db;
        $params = [
            ':user_name' => $post['Comment']['clientName'],
            ':about'     => $post['Comment']['about'],
            ':email'     => $post['Comment']['clientEmail'],
            ':text'      => $post['more']
        ];

        $db->createCommand(
            "INSERT INTO comments_fps (
                user_name,
                email,
                about,
                text
            )
            VALUES (
                :user_name,
                :email,
                :about,
                :text
            )"
        )
            ->bindValues($params)
            ->execute();
    }

    /**
     * Send email to admin with comment about federation
     *
     * @param array $post Input values from user
     */
    public function sendEmail($post)
    {
        Yii::$app->mailer
            ->compose(
                'mail_comment', [
                'post' => $post
            ])
            ->setFrom($post['Comment']['clientEmail'])
            ->setTo(Yii::$app->params['adminEmail'])
            ->setSubject('Отзыв о Федерации')
            ->send();
    }

    /**
     * Insert comment about master
     *
     * @param array $post   Input values from user
     * @param int   $id     Master id
     * @param int   $userId User id
     * @throws \yii\db\Exception
     */
    public function insertCommentAboutMaster($post, $id, $userId)
    {
        $db     = Yii::$app->db;
        $params = [
            ':id_master' => $id,
            ':text'      => $post['more'],
            ':side'      => $post['Comment']['side'],
            ':user_id'   => $userId
        ];

        $db->createCommand(
            "INSERT INTO comments (
                id_master,
                text,
                side,
                user_id
            )
            VALUES (
                :id_master,
                :text,
                :side,
                :user_id
            )"
        )
            ->bindValues($params)
            ->execute();
    }

    /**
     * Update master rating after sending a comment about him
     *
     * @param int $id Master id
     * @return bool
     * @throws \yii\db\Exception
     */
    public function updateRating($id)
    {
        $queryBuilder   = new Query();
        $masterComments = $queryBuilder
            ->select([
                'side'
            ])
            ->from('comments')
            ->where(['id_master' => $id])
            ->all();

        if (! empty($masterComments)) {
            $up = 0;
            foreach ($masterComments as $mc) {
                if ($mc['side']) {
                    $up++;
                }
            }
            $countComments = count($masterComments);
            $rating        = round($up / $countComments * 500);

            ($rating == 0) ? $rating -= $countComments : $rating += $countComments;
        } else {
            $rating = 0;
        }

        $db = Yii::$app->db;
        $db->createCommand()
            ->update('masters', [
                'rating' => $rating
            ],
                'id = ' . $id)
            ->execute();

        return true;
    }

    /**
     * Send email to admin with comment about master
     *
     * @param array $post   Input values from user
     * @param int   $id     Master id
     * @param int   $userId User id
     */
    public function sendEmailAboutMaster($post, $id, $userId)
    {
        $masterName = $this->getMasterNameById($id);
        Yii::$app->mailer
            ->compose(
                'mail_comment_about_master', [
                'post'       => $post,
                'userId'     => $userId,
                'masterName' => $masterName
            ])
            ->setFrom($post['Comment']['clientEmail'])
            ->setTo(Yii::$app->params['adminEmail'])
            ->setSubject('Отзыв о Федерации')
            ->send();
    }

    /**
     * Get master name by id
     *
     * @param int $id Master id
     * @return array|bool
     */
    protected function getMasterNameById($id)
    {
        $queryBuilder = new Query();

        $user = $queryBuilder
            ->select(['name'])
            ->from('masters')
            ->where(['id' => $id])
            ->one();

        return $user;
    }

    /**
     * Send email with callback request
     *
     * @param array $post Input values from user
     */
    public function sendEmailBackCall($post)
    {
        Yii::$app->mailer
            ->compose(
                'mail_backcall', [
                'post' => $post
            ])
            ->setFrom(Yii::$app->params['noReplyEmail'])
            ->setTo(Yii::$app->params['adminEmail'])
            ->setSubject('Обратный звонок')
            ->send();
    }
}
