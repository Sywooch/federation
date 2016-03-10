<?php
use yii\helpers\Url;

$this->title = 'Выбор мастера для редактирования';

$this->params['breadcrumbs'][] = ['label' => 'Админпанель', 'url' => ['/admin/admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Панель управления мастерами', 'url' => ['/admin/admin/masters-index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("@web/modules/" . $this->context->module->id . "/css/style.css");
$this->registerCssFile("@web/js/data_tables/media/css/jquery.dataTables.css");
$this::registerJsFile('@web/js/data_tables/media/js/jquery.dataTables.js');
?>
<?= $this->render('//layouts/headerIndex', ['typeHeader' => 'lite']) ?>

    <script type="text/javascript" language="javascript" class="init">
        $(document).ready(function() {
            fadeInContent('table');
            $('#tableOrdersToday').DataTable({
                "columns": [
                    {
                        "width": "20px"
                    },
                    null,
                    null,
                    {
                        "orderable": false,
                        "width": "20px"
                    }
                ],

                "order"         : [[1,'asc']],
                "lengthMenu"    : [[10, 15, 25, 50, 100, -1], [10, 15, 25, 50, 100, "Все"]],
                "pageLength"    : 10

                //"orderFixed": [[5,'desc']]
                //{"orderable": false}
                //{ "searchable": false }
            });
        });
    </script>

    <div class="greyBg clear">
        <div class="content">
            <div class="aboutHead fontLogo"><h1><?=$this->title ?></h1></div>

            <div class="adminMastersList">
                <p>Выберите мастера, чтобы перейти на страницу редктирования:</p>

                <table class="tableOrders hover order-column stripe hidden" id="tableOrdersToday">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя / Название организации</th>
                            <th>Статус</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?
                    foreach ($masters as $master) {
                        if (!$master['id']) continue;
                        $link = Url::to(['admin/master-reduction', 'id' => $master['id']]);
                        echo "<tr>
                            <td>{$master['id']}</td>
                            <td>{$master['name']}</td>
                            <td>{$master['status']}</td>
                            <td class='showModify'><a href='{$link}'></a></td>
                        </tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
    <div class="shadow"></div>
<?= $this->render('//layouts/readInformation_02') ?>