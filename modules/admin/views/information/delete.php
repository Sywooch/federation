<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Удаление статей';

$this->params['breadcrumbs'][] = ['label' => 'Админпанель', 'url' => ['/admin/admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Панель управления статьями', 'url' => ['/admin/information/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("@web/modules/" . $this->context->module->id . "/css/style.css");
$this->registerCssFile("@web/js/data_tables/media/css/jquery.dataTables.css");
$this::registerJsFile('@web/js/data_tables/media/js/jquery.dataTables.js');
?>
<?= $this->render('//layouts/headerIndex', ['typeHeader' => 'lite']) ?>
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function () {
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

            "order": [[0, 'desc']],
            "lengthMenu": [[10, 15, 25, 50, 100, -1], [10, 15, 25, 50, 100, "Все"]],
            "pageLength": 10
        });
    });
</script>

<div class="greyBg clear">
    <div class="content">
        <div class="aboutHead fontLogo"><h1><?= $this->title ?></h1></div>
        <div class="adminMastersList">
            <p>Выберите статью, которую хотите удалить:</p>
            <form action="<?= Url::to(['/admin/information/delete-success']) ?>" class="hidden">
                <div class='informationDeleteContainer'>

                    <table class="tableOrders hover order-column stripe" id="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Заголовок</th>
                            <th>Посмотреть</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        if (! empty($informations)) {
                            foreach ($informations as $information) {
                                $link = Url::to(['//information/information-full',
                                                 'id' => $information['id'], 'title' => $information['title']
                                ]);
                                echo "<tr>
                                    <td>{$information['id']}</td>
                                    <td>{$information['title']}</td>
                                    <td class='showModify'><a href='{$link}' target='_blank'></a></td>
                                    <td><input type='checkbox' name='{$information['id']}'
                                        value='{$information['id']}' id='{$information['id']}'/></td>
                                </tr>";
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <?= Html::submitButton('Удалить', ['class' => 'youNeedButtonAdd fontLogo']) ?>
            </form>
        </div>
    </div>
</div>
<div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
<div class="shadow"></div>
<?= $this->render('//layouts/readInformation_02') ?>
