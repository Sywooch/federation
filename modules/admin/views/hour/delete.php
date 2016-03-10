<?php
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Удалить объявления';

$this->params['breadcrumbs'][] = ['label' => 'Админпанель', 'url' => ['/admin/admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Панель управления раздела Муж на час', 'url' => ['/admin/hour/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("@web/modules/" . $this->context->module->id . "/css/style.css");
$this->registerCssFile("@web/js/data_tables/media/css/jquery.dataTables.css");
$this::registerJsFile('@web/js/data_tables/media/js/jquery.dataTables.js');
?>
<?= $this->render('//layouts/headerIndex', ['typeHeader' => 'lite']) ?>

<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function () {
        fadeInContent('table');
        $('#tableHour').DataTable({
            "columns": [
                {
                    "width": "20px"
                },
                null,
                null,
                null,
                null,
                null,
                null,
                {
                    "orderable": false,
                    "width": "20px",
                    "searchable": false
                }
            ],

            "order": [[0, 'desc']],
            "lengthMenu": [[10, 15, 25, 50, 100, -1], [10, 15, 25, 50, 100, "Все"]],
            "pageLength": 10
        });
    });
</script>

<div class='greyBg marginBottomMinus clear'>
    <div class="aboutHead fontLogo"><h1>Удалить объявления из раздела Муж на час</h1></div>
</div>
<div class="greyBg clear">
    <div class="content sendEnter">
        <p>Отметьте объявления, которые хотите удалить. Кнопка Применить действует только для текущей части таблицы.</p>
    </div>
</div>
<? $form = ActiveForm::begin([
    'action' => Url::to(['/admin/hour/delete-success'])
]); ?>
<div class='greyBg clear'>
    <div class='content'>
        <table class="tableOrders hover order-column stripe hidden" id="tableHour">
            <thead>
            <tr>
                <th>ID</th>
                <th>Заголовок</th>
                <th>Текст</th>
                <th>Дата</th>
                <th>Имя</th>
                <th>Телефон</th>
                <th>Адрес</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?
            if (! empty($hours)) {
                foreach ($hours as $hour) {
                    $timestamp   = strtotime($hour['date_hour']);
                    $currentDate = date("d.m.Y H:i", $timestamp);

                    echo "<tr>
                            <td>{$hour['id']}</td>
                            <td>{$hour['header']}</td>
                            <td>{$hour['text']}</td>
                            <td>{$currentDate}</td>
                            <td>{$hour['name_man']}</td>
                            <td>{$hour['tel']}</td>
                            <td>{$hour['location']}</td>
                            <td>
                                <div class='radio'>
                                    <input type='checkbox' name='{$hour['id']}' id='{$hour['id']}' value='0'>
                                </div>
                            </td>
                        </tr>";
                }
            }
            ?>
            </tbody>
        </table>
        <div class="content">
            <?= Html::submitButton('Применить', ['class' => 'youNeedButtonAdd fontLogo']) ?>
            <? ActiveForm::end(); ?>
        </div>
    </div>
</div>
<div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
<div class="shadow"></div>

<?= $this->render('//layouts/readInformation_02') ?>

<script type="text/javascript">
    var speed = 300;
    $("input[value='1']").click(function (e) {
        var id = e.target.id;
        $('div#' + id).animate({opacity: '0.3'}, speed);
    })
    $("input[value='0']").click(function (e) {
        var id = e.target.id;
        $('div#' + id).animate({opacity: '1'}, speed);
    })
</script>
