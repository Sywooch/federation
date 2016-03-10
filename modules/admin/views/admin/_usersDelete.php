<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Удаление пользователей';

$this->params['breadcrumbs'][] = ['label' => 'Админпанель', 'url' => ['/admin/admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Панель управления пользователями', 'url' => ['/admin/admin/users-index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("@web/modules/" . $this->context->module->id . "/css/style.css");
$this->registerCssFile("@web/js/data_tables/media/css/jquery.dataTables.css");
$this::registerJsFile('@web/js/data_tables/media/js/jquery.dataTables.js');
?>
<?= $this->render('//layouts/headerIndex', ['typeHeader' => 'lite']) ?>

    <script type="text/javascript" language="javascript" class="init">
        $(document).ready(function() {
            fadeInContent('form');
            $('#table').DataTable({
                "columns": [
                    {
                        "width": "20px"
                    },
                    null,
                    null,
                    {
                        "orderable": false,
                        "width": "10px"
                    }
                ],

                "order"         : [[1,'desc']],
                "lengthMenu"    : [[10, 15, 25, 50, 100, -1], [10, 15, 25, 50, 100, "Все"]],
                "pageLength"    : 10
            });
        });
    </script>

    <div class="greyBg clear">
        <div class="content">
            <div class="aboutHead fontLogo"><h1><?=$this->title ?></h1></div>

            <div class="adminMastersList">
                <p>Выберите пользователей, которых Вы хотите удалить. <br/> Кнопка Удалить действует только для текущей части таблицы</p>

                <form action="<?= Url::to (['/admin/admin/delete-users']) ?>" class="hidden">
                    <div class='informationDeleteContainer'>
                        <table class="tableOrders hover order-column stripe" id="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ник</th>
                                <th>Имя</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            foreach ($users as $user) {
                                if ($user['username'] == Yii::$app->user->identity->username)
                                    continue;
                                echo "<tr>
                                    <td>{$user['id']}</td>
                                    <td>{$user['username']}</td>
                                    <td>{$user['fio']}</td>
                                    <td><input type='checkbox' name='{$user['id']}' value='{$user['id']}' id='{$user['id']}'/></td>
                                </tr>";
                            }
                            ?>
                            </tbody>
                        </table>

                        <?/*
                        foreach ($users as $user) {
                            if ($user['username'] == Yii::$app->user->identity->username)
                                continue;
                            echo "<div class='labelPlusCheckbox'>
                                <input type='checkbox' name='{$user['id']}' value='{$user['id']}' id='{$user['id']}'/>
                                <label class='checkbox' for='{$user['id']}' style='float: none;'>{$user['fio']} ({$user['username']})</label>
                            </div>\n";
                        }*/
                        ?>
                    </div>
                    <?= Html::submitButton('Удалить', ['class' => 'youNeedButtonAdd fontLogo']) ?>
                </form>

            </div>

        </div>
    </div>
    <div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
    <div class="shadow"></div>
<?= $this->render('//layouts/readInformation_02') ?>

<script type="text/javascript">
    $(function(){

    });
</script>