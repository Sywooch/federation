<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Заказы';

$this->params['breadcrumbs'][] = ['label' => 'Админпанель', 'url' => ['/admin/admin/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("@web/modules/" . $this->context->module->id . "/css/style.css");

$this::registerJsFile('@web/js/leanModal.js');
$this::registerJsFile('@web/js/service_level_dropdown.js', ['position' => $this::POS_HEAD]);

$this->registerCssFile("@web/js/data_tables/media/css/jquery.dataTables.css");
$this::registerJsFile('@web/js/data_tables/media/js/jquery.dataTables.js');

$todayDate = date("d.m.Y");
?>
<?= $this->render('//layouts/headerIndex', ['typeHeader' => 'lite']) ?>
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function () {
        fadeInContent('table');
        $('#tableOrdersToday').DataTable({
            "columns": [
                null,
                null,
                null,
                null,
                null,
                null,
                { // status
                    "createdCell": function (td, cellData, rowData, row, col) {
                        if (cellData == "Не обработан") {
                            $(td).css('color', 'crimson')
                        }
                    },
                    "width": "90px", "targets": [0]
                },
                {"orderable": false}
            ],

            "order": [[4, 'desc']],
            "lengthMenu": [[10, 15, 25, 50, 100, -1], [10, 15, 25, 50, 100, "Все"]],
            "pageLength": 10

            //"orderFixed": [[5,'desc']]
            //{ "searchable": false }
        });

        $('#tableOrders').DataTable({
            "columns": [
                null,
                null,
                null,
                null,
                null,
                null,
                { // status
                    "createdCell": function (td, cellData, rowData, row, col) {
                        if (cellData == "Не обработан") {
                            $(td).css('color', 'crimson')
                        }
                    },
                    "width": "90px", "targets": [0]
                },
                {"orderable": false}
            ],

            "order": [[4, 'desc']],
            "lengthMenu": [[10, 15, 25, 50, 100, -1], [10, 15, 25, 50, 100, "Все"]],
            "pageLength": 15
        });
    });
    var link = '<?=Url::to(['/admin/orders/modify'])?>';
</script>

<div class="content">
    <div class="adminOrdersContent">
        <h2 class="fontLogo first">Заказы за сегодня, <span><?= $todayDate ?></span></h2>
        <table class="tableOrders hover order-column stripe hidden" id="tableOrdersToday">
            <thead>
            <tr>
                <th>ID</th>
                <th>Заголовок</th>
                <th>Тип заказа</th>
                <th>Услуга</th>
                <th>Дата</th>
                <th>Адрес</th>
                <th>Статус</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?
            foreach ($ordersToday as $order) {
                $timestamp   = strtotime($order['date_orders']);
                $currentDate = date("d.m.Y H:i", $timestamp);
                $id          = $order['id'] + 50000;

                echo "<tr>
                <td>{$id}</td>
                <td>{$order['header']}</td>
                <td>{$order['type_services_name']}</td>
                <td>{$order['name_services']}</td>
                <td>{$currentDate}</td>
                <td>{$order['location']}</td>
                <td>{$order['status_name']}</td>
                <td class='showModify'><a rel='leanModal' id='{$order['id']}'></a></td>
            </tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

</div>

<div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
<div class="shadow"></div>

<div class="greyBg clear">
    <div class="content">

        <div class="adminOrdersContent">
            <h2 class="fontLogo">Все заказы</h2>
            <table class="tableOrders hover order-column stripe hidden" id="tableOrders">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Заголовок</th>
                    <th>Тип заказа</th>
                    <th>Услуга</th>
                    <th>Дата</th>
                    <th>Адрес</th>
                    <th>Статус</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?
                if (! empty($orders)) {
                    foreach ($orders as $order) {
                        $timestamp   = strtotime($order['date_orders']);
                        $currentDate = date("d.m.Y H:i", $timestamp);
                        $id          = $order['id'] + 50000;

                        echo "<tr>
                    <td>{$id}</td>
                    <td>{$order['header']}</td>
                    <td>{$order['type_services_name']}</td>
                    <td>{$order['name_services']}</td>
                    <td>{$currentDate}</td>
                    <td>{$order['location']}</td>
                    <td>{$order['status_name']}</td>
                    <td class='showModify'><a rel='leanModal' id='{$order['id']}'></a></td>
                </tr>";
                    }
                }
                ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
<div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
<div class="shadow"></div>

<div class="content clear">
    <div class="paginationContainer content">
        <?
        if ($pagination->totalCount > $pagination->defaultPageSize) {
            echo "<h5>Навигация по разделам</h5>
            <p class='inEachLevel'>В каждом разделе строк: {$pagination->defaultPageSize}.<br/>
            Всего во всех разделах строк: {$pagination->totalCount} </p>";
        }
        ?>
        <?= LinkPager::widget(['pagination' => $pagination]); ?>
    </div>
</div>
<div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
<div class="shadow"></div>

<div class="overlay" id="overlay">
    <div class="overlayContent">
        <div id="orderModifyContent"></div>
        <div class="loading"></div>
    </div>
</div>

<?= $this->render('//layouts/readInformation_02') ?>
