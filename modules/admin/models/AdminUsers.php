<?
namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\db\Query;

/**
 * Class AdminUsers provides logic for handling users from admin panel
 *
 * @package app\modules\admin\models
 */
class AdminUsers extends Model
{
    /**
     * Get all users from database
     *
     * @return array
     */
    public function getAllUsers()
    {
        $queryBuilder = new Query();
        $users        = $queryBuilder
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
     * Delete user
     *
     * @param array $post Input values
     * @return bool
     * @throws \yii\db\Exception
     */
    public function deleteUsers($post)
    {
        $db = Yii::$app->db;

        if (! empty($post)) {
            foreach ($post as $pKey => $pVal) {
                if (is_integer($pKey)) {
                    $db->createCommand()
                        ->delete('users', 'id = ' . $pKey)
                        ->execute();

                    $db->createCommand()
                        ->delete('comments', 'user_id = ' . $pKey)
                        ->execute();
                }
            }
        }

        return true;
    }
}
